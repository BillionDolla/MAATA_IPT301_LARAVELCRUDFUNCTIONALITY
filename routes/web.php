<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;


Route::get('/', function() {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/dashboard/set-appointment', [DashboardController::class, 'setAppointment'])->name('dashboard.setAppointment');

Route::resource('patients', PatientController::class);
Route::resource('doctors', DoctorController::class);
Route::resource('appointments', AppointmentController::class);