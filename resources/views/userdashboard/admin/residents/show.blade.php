@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto p-6">
    <a href="{{ route('admin.residents.index') }}" class="text-green-600 hover:underline mb-4 inline-block">
        ← Back to Residents
    </a>

    <div class="bg-white shadow-md rounded-lg p-6 grid grid-cols-2 gap-8">
        <div>
            <h3 class="text-xl font-semibold text-green-700 mb-4">Personal Information</h3>
            <p><strong>Full Name:</strong> {{ $resident->full_name }}</p>
            <p><strong>Email:</strong> {{ $resident->email }}</p>
            <p><strong>Phone:</strong> {{ $resident->phone_number ?? '—' }}</p>
            <p><strong>Birthdate:</strong> {{ $resident->birthdate?->format('M d, Y') ?? '—' }}</p>
            <p><strong>Sex:</strong> {{ ucfirst($resident->sex) }}</p>
            <p><strong>Civil Status:</strong> {{ ucfirst($resident->civil_status) }}</p>
        </div>

        <div>
            <h3 class="text-xl font-semibold text-green-700 mb-4">Address Details</h3>
            <p><strong>Region:</strong> {{ $resident->region }}</p>
            <p><strong>Province:</strong> {{ $resident->province }}</p>
            <p><strong>Municipality:</strong> {{ $resident->municipality }}</p>
            <p><strong>Barangay:</strong> {{ $resident->barangay }}</p>
            <p><strong>Sitio:</strong> {{ $resident->sitio }}</p>
            <p><strong>Purok:</strong> {{ $resident->purok }}</p>
        </div>
    </div>
</div>
@endsection
