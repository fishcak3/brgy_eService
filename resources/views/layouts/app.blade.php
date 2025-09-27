<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Barangay Bakitiw E-Services Portal') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen">
        {{-- Top Navigation --}}
        <nav class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">

                    {{-- Left Side: Logo --}}
                    <div class="flex items-center space-x-2">
                        <div class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center text-white font-bold">
                            B
                        </div>
                        <div>
                            <p class="text-gray-900 font-semibold">Barangay Bakitiw</p>
                            <p class="text-xs text-gray-500">E-Services Portal</p>
                        </div>
                    </div>

                    {{-- Common links --}}
                    <a href="{{ route(Auth::user()->role . '.dashboard') }}" 
                       class="text-gray-700 hover:text-green-600 font-medium">Dashboard</a>

                    {{-- Role-specific links --}}
                    @switch(Auth::user()->role)
                        @case('resident')
                            <a href="{{ route('document-requests.index') }}" class="text-gray-700 hover:text-green-600 font-medium">My Requests</a>
                            <a href="{{ route('complaints.index') }}" class="text-gray-700 hover:text-green-600 font-medium">My complaints</a>
                            @break

                        @case('staff')
                            <a href="{{ route('staff.dashboard') }}" class="text-gray-700 hover:text-green-600 font-medium">Manage Requests</a>
                            <a href="{{ route('staff.dashboard') }}" class="text-gray-700 hover:text-green-600 font-medium">Reports</a>
                            @break

                        @case('admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-green-600 font-medium">User Management</a>
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-green-600 font-medium">System Settings</a>
                            @break
                    @endswitch

                    {{-- Right Side: User Info --}}
                    <div class="flex items-center space-x-4">
                        {{-- Notification Bell --}}
                        @auth
                        <button class="relative text-gray-600 hover:text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 17h5l-1.405-1.405A2.032 
                                         2.032 0 0118 14.158V11a6.002 
                                         6.002 0 00-4-5.659V5a2 2 0 
                                         10-4 0v.341C7.67 6.165 6 
                                         8.388 6 11v3.159c0 .538-.214 
                                         1.055-.595 1.436L4 17h5m6 
                                         0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        @endauth

                        {{-- User Dropdown --}}
                        <div class="relative">
                            <button onclick="document.getElementById('userDropdown').classList.toggle('hidden')" 
                                    class="flex items-center focus:outline-none">
                                <div class="h-8 w-8 rounded-full overflow-hidden border">
                                    @if(Auth::user()->photo)
                                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                             alt="Profile Photo"
                                             class="h-full w-full object-cover">
                                    @else
                                        <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" 
                                                  d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" 
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                                <span class="ml-2 text-gray-700 font-medium">
                                    {{ Auth::user()->name }}
                                </span>
                                <svg class="ml-1 w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.65a.75.75 0 01-1.08 0l-4.25-4.65a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    My Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Main Content --}}
        <main>
            @yield('content')
        </main>
    </div>

    @stack('scripts')

    <script>
        // Close dropdown if clicking outside
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown && !e.target.closest('[onclick]') && !e.target.closest('#userDropdown')) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
