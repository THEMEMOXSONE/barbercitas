<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Models\BarberSetting;
use App\Models\PortfolioImage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $settings = BarberSetting::first();
    $images = PortfolioImage::all();
    return view('welcome', compact('settings', 'images'));
});

Route::get('/book', [BookingController::class, 'create'])->name('book');
Route::post('/book', [BookingController::class, 'store'])->name('book.store');
Route::get('/book/success', [BookingController::class, 'success'])->name('book.success');
Route::delete('/book/{appointment}', [BookingController::class, 'destroy'])->name('book.destroy')->middleware('auth');

Route::get('/dashboard', function () {
    $appointments = Auth::user()->appointments()->orderBy('appointment_date', 'desc')->get();
    return view('dashboard', compact('appointments'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/appointments/{appointment}/complete', [AdminController::class, 'markCompleted'])->name('appointments.complete');
    Route::post('/appointments/{appointment}/cancel', [AdminController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/walk-in', [AdminController::class, 'storeWalkIn'])->name('walkin.store');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::get('/report', [AdminController::class, 'generateReport'])->name('report');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
