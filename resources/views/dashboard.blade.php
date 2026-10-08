@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Dashboard</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Doctors</h5>
                    <p class="display-4 fw-bold">{{ $doctorCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Patients</h5>
                    <p class="display-4 fw-bold">{{ $patientCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Appointments</h5>
                    <p class="display-4 fw-bold">{{ $appointmentCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Set Appointment</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('dashboard.setAppointment') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="patient_id" class="form-label">Patient</label>
                                <select name="patient_id" class="form-control" required>
                                    <option value="">-- Select Patient --</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->student_id }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="doctor_id" class="form-label">Doctor</label>
                                <select name="doctor_id" class="form-control" required>
                                    <option value="">-- Select Doctor --</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="appointment_date" class="form-label">Appointment Date</label>
                                <input type="date" class="form-control" name="appointment_date" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="appointment_time" class="form-label">Appointment Time</label>
                                <input type="time" class="form-control" name="appointment_time">
                            </div>
                        </div>

                        <div class="mb-3" style="max-width: 300px;">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Completed">Completed</option>
                                <option value="Pending">Pending</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Set Appointment</button>
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">View All Appointments</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Recent Appointments</h5>
                </div>
                <div class="card-body">
                    @php
                        $recent = \App\Models\Appointment::with(['patient', 'doctor'])->latest()->take(5)->get();
                    @endphp
                    @if($recent->isEmpty())
                        <p class="text-muted mb-0">No appointments yet.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($recent as $appt)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>
                                        <strong>{{ $appt->patient->name ?? 'N/A' }}</strong>
                                        with {{ $appt->doctor->name ?? 'N/A' }}
                                    </span>
                                    <span class="badge bg-primary">{{ $appt->status }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection