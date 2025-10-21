@extends('layouts.sidebar')

@section('content')
<div class="p-8 bg-white rounded-lg shadow-md">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-700">Official Details</h1>
        <a href="{{ route('admin.officials.index') }}" class="text-green-600 hover:underline">← Back to Officials</a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- View Form (read-only except position) --}}
    <form action="{{ route('admin.officials.update', $official->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @csrf
        @method('PUT')

        {{-- LEFT SIDE --}}
        <div class="space-y-6">

            {{-- Profile --}}
            <div class="text-center">
                <div class="w-32 h-32 mx-auto border-4 border-green-500 rounded-full overflow-hidden">
                    <img src="{{ $official->photo ? asset('storage/' . $official->photo) : asset('images/default-profile.png') }}" 
                         alt="Profile Photo" class="object-cover w-full h-full">
                </div>
                <h2 class="mt-4 text-lg font-semibold text-gray-800">{{ $official->full_name }}</h2>
                <p class="text-gray-500">{{ $official->position->title ?? 'Unassigned' }}</p>
            </div>

            {{-- Basic Details --}}
            <div class="bg-gray-50 p-4 rounded-lg text-sm">
                <p><strong>Email:</strong> {{ $official->email }}</p>
                <p><strong>Phone:</strong> {{ $official->phone_number ?? 'N/A' }}</p>
                <p><strong>Role:</strong> {{ ucfirst($official->role) }}</p>
                <p><strong>Voter:</strong> {{ $official->voter ? 'Yes' : 'No' }}</p>
                <p><strong>Senior Citizen:</strong> {{ $official->senior_citizen ? 'Yes' : 'No' }}</p>
            </div>

            {{-- Sectoral Classification --}}
            <div>
                <h3 class="text-green-700 font-semibold mb-2">Sectoral Classification</h3>
                <div class="grid grid-cols-2 gap-x-3 text-sm">
                    <p>Solo Parent: {{ $official->solo_parent ? 'Yes' : 'No' }}</p>
                    <p>OFW: {{ $official->ofw ? 'Yes' : 'No' }}</p>
                    <p>PWD: {{ $official->pwd ? 'Yes' : 'No' }}</p>
                    <p>Out of School: {{ $official->out_of_school_children ? 'Yes' : 'No' }}</p>
                    <p>OSA: {{ $official->osa ? 'Yes' : 'No' }}</p>
                    <p>Unemployed: {{ $official->unemployed ? 'Yes' : 'No' }}</p>
                    <p>Labor Force: {{ $official->laborforce ? 'Yes' : 'No' }}</p>
                    <p>ISY/ISC: {{ $official->isy_isc ? 'Yes' : 'No' }}</p>
                </div>
            </div>

            {{-- Residency & Verification --}}
            <div>
                <h3 class="text-green-700 font-semibold mb-2">Residency & Verification</h3>
                <p><strong>Residency Start:</strong> {{ $official->residency_start_date?->format('M d, Y') ?? 'N/A' }}</p>
                <p><strong>Previous Address:</strong> {{ $official->previous_address ?? 'N/A' }}</p>
                <p><strong>Verified:</strong> {{ $official->residency_verified ? 'Yes' : 'No' }}</p>
                <p><strong>Verification Date:</strong> {{ $official->verification_date?->format('M d, Y') ?? 'N/A' }}</p>
                <p><strong>Verified By:</strong> {{ $official->verified_by ?? 'N/A' }}</p>
            </div>

            {{-- Community Info --}}
            <div>
                <h3 class="text-green-700 font-semibold mb-2">Community Information</h3>
                <p><strong>Mother’s Maiden Name:</strong> {{ $official->mother_maiden_name ?? 'N/A' }}</p>
                <p><strong>Proof of Residency:</strong> {{ $official->proof_of_residency_type_id ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="space-y-6">

            {{-- Personal Information (read-only) --}}
            <div>
                <h3 class="text-green-700 font-semibold mb-3">Personal Information</h3>
                <div class="text-sm space-y-1">
                    <p><strong>Full Name:</strong> {{ $official->full_name }}</p>
                    <p><strong>Birthdate:</strong> {{ $official->birthdate?->format('M d, Y') ?? 'N/A' }}</p>
                    <p><strong>Sex:</strong> {{ ucfirst($official->sex ?? 'N/A') }}</p>
                    <p><strong>Civil Status:</strong> {{ ucfirst($official->civil_status ?? 'N/A') }}</p>
                </div>
            </div>

            {{-- Address Details (read-only) --}}
            <div>
                <h3 class="text-green-700 font-semibold mb-3">Address Details</h3>
                <div class="text-sm space-y-1">
                    <p><strong>Region:</strong> {{ $official->region }}</p>
                    <p><strong>Province:</strong> {{ $official->province }}</p>
                    <p><strong>Municipality:</strong> {{ $official->municipality }}</p>
                    <p><strong>Barangay:</strong> {{ $official->barangay }}</p>
                    <p><strong>Purok:</strong> {{ $official->purok }}</p>
                    <p><strong>Sitio:</strong> {{ $official->sitio }}</p>
                </div>
            </div>

            {{-- Editable Official Position --}}
            <div>
                <h3 class="text-green-700 font-semibold mb-3">Official Position</h3>
                <select name="position_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">-- Select Position --</option>
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}" {{ $official->position_id == $position->id ? 'selected' : '' }}>
                            {{ $position->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Save Button --}}
            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    Update Position
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
