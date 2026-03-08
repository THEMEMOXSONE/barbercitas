<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\BarberSetting;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $appointments = Appointment::orderBy('appointment_date', 'asc')
                                    ->orderBy('appointment_time', 'asc')
                                    ->get();
        $settings = BarberSetting::first();
        return view('admin.dashboard', compact('appointments', 'settings'));
    }

    public function markCompleted(Request $request, Appointment $appointment)
    {
        $request->validate([
            'final_price' => 'required|numeric|min:0'
        ]);

        $appointment->status = 'completed';
        $appointment->final_price = $request->final_price;
        $appointment->save();

        return back()->with('success', 'Cita marcada como completada con cobro de $' . $request->final_price);
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->status = 'cancelled';
        $appointment->save();
        return back()->with('success', 'Cita cancelada correctamente por administrador.');
    }

    public function storeWalkIn(Request $request)
    {
        $request->validate([
            'guest_name' => 'required|string|max:255',
            'final_price' => 'required|numeric|min:0'
        ]);

        Appointment::create([
            'guest_name' => $request->guest_name,
            'appointment_date' => now()->toDateString(),
            'appointment_time' => now()->toTimeString(),
            'status' => 'completed',
            'is_walk_in' => true,
            'final_price' => $request->final_price,
            'user_id' => auth()->id() // Admin processing it
        ]);

        return back()->with('success', 'Walk-in registrado exitosamente.');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'base_price' => 'required|numeric|min:0',
        ]);

        $settings = BarberSetting::first();
        if (!$settings) {
            $settings = new BarberSetting();
        }

        $settings->fill($request->only(['name', 'bio', 'experience_years', 'base_price']));
        $settings->save();

        return back()->with('success', 'Configuración actualizada correctamente.');
    }

    public function generateReport(Request $request)
    {
        $days = (int) $request->get('days', 7);
        if ($days > 365) $days = 365;

        $startDate = now()->subDays($days)->toDateString();
        
        $appointments = Appointment::where('status', 'completed')
            ->where('appointment_date', '>=', $startDate)
            ->orderBy('appointment_date', 'desc')
            ->get();
            
        $totalIncome = $appointments->sum('final_price');
        $settings = BarberSetting::first();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.report', compact('appointments', 'totalIncome', 'days', 'settings'));
        
        return $pdf->download('reporte_ingresos_' . now()->format('Y_m_d') . '.pdf');
    }
}
