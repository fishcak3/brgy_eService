<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Barangay Aliaga E-Services Portal') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="flex bg-gray-100 font-sans antialiased">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg min-h-screen fixed top-0 left-0 flex flex-col justify-between transition-transform duration-300 md:translate-x-0" id="sidebar">
        <div>
            <!-- Branding -->
            <div class="p-6 border-b">
                <h1 class="text-xl font-bold text-green-600">{{ config('barangay.name') }}</h1>
                <p class="text-sm text-gray-500">E-Services Portal</p>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 space-y-4">
                <div class="px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Core Modules</div>
                <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="flex items-center px-6 py-2 text-gray-700 hover:bg-green-100">
                    Dashboard
                </a>

                @if(Auth::user()->role === 'staff')
                    <a href="{{ route('staff.requests.index') }}" class="flex items-center px-6 py-2 text-gray-700 hover:bg-green-100">
                        Manage Requests
                    </a>
                    <a href="{{ route('staff.complaints.index') }}" class="flex items-center px-6 py-2 text-gray-700 hover:bg-green-100">
                        Manage Complaints
                    </a>

                    {{--
                    <a href="{{ route('staff.facility_bookings.index') }}" class="flex items-center px-6 py-2 text-gray-700 hover:bg-green-100">
                        Facility Booking
                    </a>
                    --}}

                    <a href="{{ route('staff.residents.index') }}" class="flex items-center px-6 py-2 text-gray-700 hover:bg-green-100">
                        Profiling
                    </a>

                    <a href="{{ route('staff.reports.index') }}" class="flex items-center px-6 py-2 text-gray-700 hover:bg-green-100">
                        Analytics & Reports
                    </a>
                @endif

                @if(Auth::user()->role === 'admin')
                    <div class="px-6 mt-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Administration</div>

                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-2 text-gray-700 hover:bg-green-100">
                        User Management
                    </a>

                    <a href="{{ route('admin.requests.index') }}" class="flex items-center px-6 py-2 text-gray-700 hover:bg-green-100">
                        Requests
                    </a>

                    <a href="{{ route('admin.complaints.index') }}" class="flex items-center px-6 py-2 text-gray-700 hover:bg-green-100">
                        Complaints
                    </a>

                    <a href="{{ route('admin.residents.index') }}" class="flex items-center px-6 py-2 text-gray-700 hover:bg-green-100">
                        Residents 
                    </a>

                    <!-- Barangay Officials (Collapsible) -->
                    <details class="group">
                        <summary class="flex items-center px-6 py-2 text-gray-700 hover:bg-green-100 cursor-pointer list-none">
                            Barangay Officials
                            <svg class="ml-auto w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                            <div class="ml-12 space-y-1 mt-1">
                                <a href="{{ route('admin.officials.index') }}" 
                                class="block py-1 text-sm text-gray-600 hover:text-gray-900">
                                Officials
                                </a>

                                <a href="{{ route('admin.officials.endTerm.index') }}" 
                                class="block py-1 text-sm text-gray-600 hover:text-gray-900">
                                Official End Term
                                </a>
                            </div>
                    </details>

                    <a href="{{ route('admin.positions.index') }}" class="flex items-center px-6 py-2 text-gray-700 hover:bg-green-100">
                        Manage Positions
                    </a>

                    <a href="{{ route('admin.system.settings') }}" class="flex items-center px-6 py-2 text-gray-700 hover:bg-green-100">
                        System Settings
                    </a>
                @endif
            </nav>
        </div>

        <!-- Spinning Logo -->
        <div class="flex justify-center items-center py-10">
            <img src="{{ asset(config('barangay.logo')) }}" alt="Barangay Logo" class="w-28 h-28 animate-spin-slow">
        </div>
    </aside>

    <!-- Sidebar toggle for mobile -->
    <button class="md:hidden fixed top-4 left-4 bg-green-600 text-white p-2 rounded z-50" onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
    </button>

    <style>
    @keyframes spin-slow {
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 21s linear infinite;
    }
    #sidebar { transform: translateX(0); }
    #sidebar.-translate-x-full { transform: translateX(-100%); }
    </style>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col ml-64">
        <header class="bg-white border-b shadow p-4 flex justify-end items-center sticky top-0 z-40">
            <div class="flex items-center space-x-4">
                {{-- Notifications --}}
                @php
                    $notifications = \Illuminate\Notifications\DatabaseNotification::where('notifiable_id', auth()->id())
                        ->latest()->take(5)->get();
                    $unreadCount = \Illuminate\Notifications\DatabaseNotification::where('notifiable_id', auth()->id())
                        ->whereNull('read_at')->count();
                @endphp

                <div class="relative">
                    <button onclick="document.getElementById('notifDropdown').classList.toggle('hidden')" 
                            class="relative text-gray-600 hover:text-green-600 focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 17h5l-1.405-1.405A2.032 
                                     2.032 0 0118 14.158V11a6.002 
                                     6.002 0 00-4-5.659V5a2 2 0 
                                     10-4 0v.341C7.67 6.165 6 
                                     8.388 6 11v3.159c0 .538-.214 
                                     1.055-.595 1.436L4 17h5m6 
                                     0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        @endif
                    </button>
                    <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 max-h-96 overflow-y-auto">
                        <div class="p-3 border-b text-sm font-semibold text-gray-700">Notifications</div>
                        @forelse($notifications as $notif)
                            <div class="px-4 py-2 text-sm border-b {{ $notif->read_at ? 'bg-white' : 'bg-gray-100' }}">
                                <p class="font-medium text-gray-800">{{ $notif->data['title'] ?? 'Notification' }}</p>
                                <p class="text-gray-600">{{ $notif->data['message'] ?? '' }}</p>
                                <p class="text-xs text-gray-500">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <div class="px-4 py-2 text-sm text-gray-500">No notifications yet.</div>
                        @endforelse
                        <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-center text-green-600 hover:bg-gray-100">
                           View all
                        </a>
                    </div>
                </div>

                {{-- User Dropdown --}}
                <div class="relative">
                    <button onclick="document.getElementById('userDropdown').classList.toggle('hidden')" class="flex items-center focus:outline-none">
                        <div class="h-10 w-10 rounded-full overflow-hidden border">
                            @if(Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile Photo" class="h-full w-full object-cover">
                            @else
                                <svg class="h-10 w-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </div>
                        <span class="ml-2 text-gray-700 font-medium">{{ ucwords(Auth::user()->resident->lname ?? '') }}, {{ ucwords(Auth::user()->resident->fname ?? '') }}</span>
                        <svg class="ml-1 w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.65a.75.75 0 01-1.08 0l-4.25-4.65a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- ✅ Page Content -->
        <main class="p-6">
            @yield('content')
            @livewireScripts
        </main>
    </div>

    <!-- ✅ Load Chart.js here (after content is loaded) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @stack('scripts')
</body>
</html>
