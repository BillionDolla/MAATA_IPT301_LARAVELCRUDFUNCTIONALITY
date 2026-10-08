@extends('layouts.app')

@section('title', 'Patients')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>List of Patients</h2>
    <a href="{{ route('patients.create') }}" class="btn btn-primary">Add Patient</a>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Course</th>
            <th>Year Level</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($patients as $patient)
        <tr>
            <td>{{ $patient->student_id }}</td>
            <td>{{ $patient->name }}</td>
            <td>{{ $patient->course }}</td>
            <td>{{ $patient->year_level }}</td>
            <td>
                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                    onClick="return confirm('Are you sure you want to delete this patient?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No patients found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection