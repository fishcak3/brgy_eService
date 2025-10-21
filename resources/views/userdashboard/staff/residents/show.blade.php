@extends('layouts.sidebar')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold">Resident Profile</h1>
        <a href="{{ route('staff.residents.index') }}" class="text-sm text-indigo-600 hover:underline">← Back to List</a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold mb-2 text-gray-700">Personal Information</h2>
                <p><strong>Full Name:</strong> {{ $resident->name }}</p>
                <p><strong>Email:</strong> {{ $resident->email }}</p>
                <p><strong>Phone:</strong> {{ $resident->phone_number ?? 'N/A' }}</p>
                <p><strong>Sex:</strong> {{ ucfirst($resident->sex ?? 'N/A') }}</p>
                <p><strong>Birthdate:</strong> {{ $resident->birthdate ? \Carbon\Carbon::parse($resident->birthdate)->format('F d, Y') : 'N/A' }}</p>
                <p><strong>Age:</strong> {{ $resident->age ?? 'N/A' }}</p>
                <p><strong>Civil Status:</strong> {{ ucfirst($resident->civil_status ?? 'N/A') }}</p>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-2 text-gray-700">Address Information</h2>
                <p><strong>Region:</strong> {{ $resident->region ?? 'N/A' }}</p>
                <p><strong>Province:</strong> {{ $resident->province ?? 'N/A' }}</p>
                <p><strong>Municipality:</strong> {{ $resident->municipality ?? 'N/A' }}</p>
                <p><strong>Barangay:</strong> {{ $resident->barangay ?? 'N/A' }}</p>
                <p><strong>Sitio:</strong> {{ $resident->sitio ?? 'N/A' }}</p>
                <p><strong>Purok:</strong> {{ $resident->purok ?? 'N/A' }}</p>
                <p><strong>Household ID:</strong> {{ $resident->household_id ?? 'N/A' }}</p>
            </div>
        </div>

        <hr class="my-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold mb-2 text-gray-700">Residency Details</h2>
                <p><strong>Residency Start Date:</strong> 
                    {{ $resident->residency_start_date ? \Carbon\Carbon::parse($resident->residency_start_date)->format('F d, Y') : 'N/A' }}
                </p>
                <p><strong>Verified:</strong> {{ $resident->residency_verified ? 'Yes' : 'No' }}</p>
                <p><strong>Verification Date:</strong> 
                    {{ $resident->verification_date ? \Carbon\Carbon::parse($resident->verification_date)->format('F d, Y') : 'N/A' }}
                </p>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-2 text-gray-700">Additional Info</h2>
                <p><strong>Mother's Maiden Name:</strong> {{ $resident->mother_maiden_name ?? 'N/A' }}</p>
                <p><strong>Senior Citizen:</strong> {{ $resident->senior_citizen ? 'Yes' : 'No' }}</p>
                <p><strong>Voter:</strong> {{ $resident->voter ? 'Yes' : 'No' }}</p>
                <p><strong>Solo Parent:</strong> {{ $resident->solo_parent ? 'Yes' : 'No' }}</p>
                <p><strong>PWD:</strong> {{ $resident->pwd ? 'Yes' : 'No' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
