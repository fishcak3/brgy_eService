@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Add New Resident</h2>

    <form action="{{ route('admin.residents.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Basic Information -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>First Name</label>
                <input type="text" name="fname" class="border rounded w-full p-2" required>
            </div>

            <div>
                <label>Middle Name</label>
                <input type="text" name="mname" class="border rounded w-full p-2">
            </div>

            <div>
                <label>Last Name</label>
                <input type="text" name="lname" class="border rounded w-full p-2" required>
            </div>

            <div>
                <label>Suffix</label>
                <input type="text" name="suffix" class="border rounded w-full p-2">
            </div>
        </div>

        <!-- Personal Info -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Phone Number</label>
                <input type="text" name="phone_number" class="border rounded w-full p-2">
            </div>
            <div>
                <label>Birthdate</label>
                <input type="date" name="birthdate" class="border rounded w-full p-2">
            </div>
            <div>
                <label>Age</label>
                <input type="number" name="age" class="border rounded w-full p-2">
            </div>
            <div>
                <label>Sex</label>
                <select name="sex" class="border rounded w-full p-2">
                    <option value="">-- Select --</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div>
                <label>Civil Status</label>
                <select name="civil_status" class="border rounded w-full p-2">
                    <option value="">-- Select --</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="widowed">Widowed</option>
                </select>
            </div>
        </div>

        <!-- Address -->
        <div class="grid grid-cols-2 gap-4">
            <div><label>Region</label><input type="text" name="region" class="border rounded w-full p-2"></div>
            <div><label>Province</label><input type="text" name="province" class="border rounded w-full p-2"></div>
            <div><label>Municipality</label><input type="text" name="municipality" class="border rounded w-full p-2"></div>
            <div><label>Barangay</label><input type="text" name="barangay" class="border rounded w-full p-2"></div>
            <div><label>Sitio</label><input type="text" name="sitio" class="border rounded w-full p-2"></div>
            <div><label>Purok</label><input type="text" name="purok" class="border rounded w-full p-2"></div>
        </div>

        <!-- Household Info -->
        <div>
            <label>Household ID</label>
            <input type="text" name="household_id" class="border rounded w-full p-2">
        </div>

        <!-- Sectoral Info -->
        <div class="grid grid-cols-2 gap-2">
            @foreach ([
                'solo_parent' => 'Solo Parent',
                'ofw' => 'OFW',
                'is_pwd' => 'PWD',
                'is_4ps' => '4Ps Beneficiary',
                'out_of_school_children' => 'Out of School Children',
                'osa' => 'OSA',
                'unemployed' => 'Unemployed',
                'laborforce' => 'Laborforce',
                'isy_isc' => 'ISY/ISC',
                'senior_citizen' => 'Senior Citizen',
                'voter' => 'Registered Voter'
            ] as $field => $label)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="{{ $field }}" value="1">
                    <span>{{ $label }}</span>
                </label>
            @endforeach
        </div>

        <!-- Family Info -->
        <div>
            <label>Mother's Maiden Name</label>
            <input type="text" name="mother_maiden_name" class="border rounded w-full p-2">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Save Resident
        </button>
    </form>
</div>
@endsection
