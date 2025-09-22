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

                    {{-- Center: Dynamic Navigation Links --}}
                    <div class="hidden md:flex space-x-8">
                        @auth
                            {{-- Common links --}}
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-green-600 font-medium">Dashboard</a>
                            <a href="{{ route('profile') }}" class="text-gray-700 hover:text-green-600 font-medium">My Profile</a>

                            {{-- Role-specific links --}}
                            @switch(Auth::user()->role)
                                @case('resident')
                                    <a href="" class="text-gray-700 hover:text-green-600 font-medium">My Requests</a>
                                    <a href="" class="text-gray-700 hover:text-green-600 font-medium">Announcements</a>
                                    @break

                                @case('staff')
                                    <a href="" class="text-gray-700 hover:text-green-600 font-medium">Manage Requests</a>
                                    <a href="" class="text-gray-700 hover:text-green-600 font-medium">Reports</a>
                                    @break

                                @case('admin')
                                    <a href="" class="text-gray-700 hover:text-green-600 font-medium">User Management</a>
                                    <a href="" class="text-gray-700 hover:text-green-600 font-medium">System Settings</a>
                                    @break
                            @endswitch
                        @endauth
                    </div>

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
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-700 font-medium">
                                {{ Auth::user()->name ?? 'Guest' }}
                            </span>
                            <span class="text-xs text-gray-500 capitalize">
                                {{ Auth::user()->role ?? '' }}
                            </span>
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M10 9a3 3 0 100-6 3 3 0 
                                             000 6zm-7 9a7 7 0 1114 0H3z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Logout --}}
                        @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M17 16l4-4m0 0l-4-4m4 
                                             4H7m6 4v1a2 2 0 11-4 
                                             0v-1m0-8V7a2 2 0 114 0v1"/>
                                </svg>
                            </button>
                        </form>
                        @endauth
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
</body>
</html>
