@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    {{-- Page Title --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
        <button type="submit" form="profileForm"
            class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">
            Save Changes
        </button>
    </div>

    {{-- Success message --}}
    @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Left Card: Profile summary --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex flex-col items-center">
                {{-- Profile Photo --}}
                <div class="h-24 w-24 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                             alt="Profile Photo" 
                             class="h-full w-full object-cover">
                    @else
                        <span class="text-2xl font-bold text-gray-500">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </span>
                    @endif
                </div>

                {{-- Name --}}
                <h2 class="mt-4 text-lg font-semibold text-gray-900">{{ Auth::user()->name }}</h2>

                {{-- Role Badge --}}
                <span class="mt-1 px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 capitalize">
                    {{ Auth::user()->role }}
                </span>

                {{-- Email --}}
                <p class="mt-2 text-sm text-gray-500">{{ Auth::user()->email }}</p>

                {{-- Joined date --}}
                <p class="mt-2 flex items-center text-xs text-gray-400">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 
                                 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Joined {{ Auth::user()->created_at->format('M d, Y') }}
                </p>
            </div>
        </div>

        {{-- Right Side: Form --}}
        <div class="md:col-span-2 space-y-6">

            <form id="profileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Personal Information --}}
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Full Name --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" 
                                   value="{{ old('name', Auth::user()->name) }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        {{-- Email (read-only) --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email" 
                                   value="{{ old('email', Auth::user()->email) }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
                        </div>

                        {{-- Phone Number --}}
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" 
                                   value="{{ old('phone_number', Auth::user()->phone_number) }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        {{-- Date of Birth --}}
                        <div>
                            <label for="birthdate" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" name="birthdate" id="birthdate" 
                                   value="{{ old('birthdate', Auth::user()->birthdate) }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        {{-- Gender --}}
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                            <select name="gender" id="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select</option>
                                <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        {{-- Civil Status --}}
                        <div>
                            <label for="civil_status" class="block text-sm font-medium text-gray-700">Civil Status</label>
                            <input type="text" name="civil_status" id="civil_status" 
                                   value="{{ old('civil_status', Auth::user()->civil_status) }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        {{-- Address --}}
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" name="address" id="address" 
                                   value="{{ old('address', Auth::user()->address) }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        {{-- Occupation --}}
                        <div class="md:col-span-2">
                            <label for="occupation" class="block text-sm font-medium text-gray-700">Occupation</label>
                            <input type="text" name="occupation" id="occupation" 
                                   value="{{ old('occupation', Auth::user()->occupation) }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                </div>

                {{-- Password Change --}}
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Change Password</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" name="password" id="password"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                </div>
            </form>

            {{-- Account Management --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Management</h3>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-100 text-red-600 rounded hover:bg-red-200"
                        onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
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
