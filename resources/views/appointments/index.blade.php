@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>List of Appointments</h2>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary">Add Appointment</a>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Appointment Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($appointments as $appointment)
        <tr>
            <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
            <td>{{ $appointment->doctor->name ?? 'N/A' }}</td>
            <td>{{ $appointment->appointment_date }}</td>
            <td>{{ $appointment->status }}</td>
            <td>
                <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                    onClick="return confirm('Are you sure you want to delete this appointment?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No appointments found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection