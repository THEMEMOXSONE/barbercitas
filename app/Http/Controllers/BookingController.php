<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\BarberSetting;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create()
    {
        $settings = BarberSetting::first();
        
        $busyAppointments = Appointment::where('status', 'pending')
            ->where('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get(['appointment_date', 'appointment_time'])
            ->filter(function ($app) {
                if ($app->appointment_date === now()->toDateString()) {
                    return $app->appointment_time > now()->toTimeString();
                }
                return true;
            });

        return view('book', compact('settings', 'busyAppointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guest_name' => Auth::check() ? 'nullable' : 'required|string|max:255',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
        ]);

        $requestedDateTime = \Carbon\Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);
        
        if ($requestedDateTime->isPast()) {
            return back()->withErrors(['appointment_time' => 'No puedes agendar una cita en el pasado.'])->withInput();
        }

        $startWindow = $requestedDateTime->copy()->subMinutes(29)->toTimeString();
        $endWindow = $requestedDateTime->copy()->addMinutes(29)->toTimeString();

        $overlap = Appointment::where('appointment_date', $request->appointment_date)
            ->where('status', '!=', 'cancelled')
            ->whereBetween('appointment_time', [$startWindow, $endWindow])
            ->exists();

        if ($overlap) {
            return back()->withErrors(['appointment_time' => 'El horario seleccionado choca con otra cita. Toma en cuenta que cada cita dura 30 minutos en promedio, así que selecciona un espacio disponible.'])->withInput();
        }

        $appointment = Appointment::create([
            'user_id' => Auth::id(),
            'guest_name' => Auth::check() ? Auth::user()->name : $request->guest_name,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
        ]);

        if (Auth::check()) {
            // Authenticad users go to their dashboard
            return redirect()->route('dashboard')->with('success', 'Cita agendada correctamente.');
        }

        // Guests see the screenshot screen
        return redirect()->route('book.success')->with('appointment_id', $appointment->id);
    }

    public function success()
    {
        if (!session('appointment_id')) {
            return redirect('/');
        }

        $appointment = Appointment::findOrFail(session('appointment_id'));
        return view('book-success', compact('appointment'));
    }

    public function destroy(Appointment $appointment)
    {
        if ($appointment->user_id == Auth::id()) {
            $appointment->status = 'cancelled';
            $appointment->save();
        }
        return back()->with('success', 'Cita cancelada correctamente.');
    }
}
