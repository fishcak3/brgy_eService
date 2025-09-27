{{-- resources/views/profile/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">My Profile</h1>
    <p class="text-gray-600 mb-6">Manage your personal information and account settings</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Left Column (Profile Card) --}}
        <div class="bg-white rounded-lg shadow p-6 text-center">
            {{-- Avatar --}}
            <div class="w-20 h-20 mx-auto rounded-full bg-green-100 flex items-center justify-center text-2xl font-bold text-green-700">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <h2 class="mt-4 text-xl font-semibold text-gray-900">
                {{ auth()->user()->name }}
            </h2>

            <span class="inline-block bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full mt-2">
                Resident
            </span>

            <p class="mt-4 text-gray-600">
                <i class="fas fa-envelope"></i> {{ auth()->user()->email }}
            </p>
            <p class="text-sm text-gray-500">Joined {{ auth()->user()->created_at->format('F j, Y') }}</p>
        </div>

        {{-- Right Column (Profile Info) --}}
        <div class="col-span-2 space-y-6">
            {{-- Personal Info --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>
                    <a href="{{ route('profile.edit') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                        Edit Profile
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <p><strong>Full Name:</strong> {{ auth()->user()->name }}</p>
                    <p><strong>Email Address:</strong> {{ auth()->user()->email }} (Cannot be changed)</p>
                    <p><strong>Phone Number:</strong> {{ auth()->user()->phone ?? 'Not provided' }}</p>
                    <p><strong>Date of Birth:</strong> {{ auth()->user()->dob ?? 'Not provided' }}</p>
                    <p><strong>Gender:</strong> {{ auth()->user()->gender ?? 'Not provided' }}</p>
                    <p><strong>Civil Status:</strong> {{ auth()->user()->civil_status ?? 'Not provided' }}</p>
                    <p><strong>Address:</strong> {{ auth()->user()->address ?? 'Not provided' }}</p>
                    <p><strong>Occupation:</strong> {{ auth()->user()->occupation ?? 'Not provided' }}</p>
                </div>
            </div>

            {{-- Emergency Contact --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Emergency Contact</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <p><strong>Emergency Contact Name:</strong> {{ auth()->user()->emergency_contact_name ?? 'Not provided' }}</p>
                    <p><strong>Emergency Contact Phone:</strong> {{ auth()->user()->emergency_contact_phone ?? 'Not provided' }}</p>
                </div>
            </div>

            {{-- Additional Notes --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Notes</h3>
                <p class="text-sm text-gray-700">
                    {{ auth()->user()->notes ?? 'No additional information provided' }}
                </p>
            </div>

            {{-- Account Management --}}
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-red-600 mb-2">Account Management</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Advanced account settings and actions
                </p>
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
                        Request Account Deletion
                    </button>
                </form>
                <p class="mt-2 text-xs text-gray-500">
                    For other account changes or issues, please contact the barangay office directly.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
