<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;


class DashboardController extends Controller
{
    public function index(Request $request) {
        $patientCount = Patient::count();
        $doctorCount = Doctor::count();
        $appointmentCount = Appointment::count();

        $patients = Patient::all();
        $doctors = Doctor::all();

        return view('dashboard', compact(
            'patientCount',
            'doctorCount',
            'appointmentCount',
            'patients',
            'doctors'
        )); 
    }

    public function setAppointment(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'nullable',
            'status' => 'required'
        ]);

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => $request->status
        ]);

        return redirect()
        ->route('dashboard')
        ->with('success', 'Appointment set successfully.');
    }
}
