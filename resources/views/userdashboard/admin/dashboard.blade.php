{{-- resources/views/staff-dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Welcome Header --}}
    <div class="mb-8">
        <h1 class="text-3xl text-gray-900 mb-2">Staff Dashboard</h1>
        <p class="text-gray-600">Welcome, {{ Auth::user()->name }}. Manage barangay services and residents.</p>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="p-6 border rounded-lg shadow bg-white flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Pending Requests</p>
                <p class="text-2xl text-gray-900">{{ $requests->where('status', 'pending')->count() }}</p>
            </div>
            <x-lucide-alert-circle class="w-8 h-8 text-yellow-600"/>
        </div>

        <div class="p-6 border rounded-lg shadow bg-white flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Processing</p>
                <p class="text-2xl text-gray-900">{{ $requests->where('status', 'processing')->count() }}</p>
            </div>
            <x-lucide-clock class="w-8 h-8 text-blue-500"/>
        </div>

        <div class="p-6 border rounded-lg shadow bg-white flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Open Complaints</p>
                <p class="text-2xl text-gray-900">{{ $complaints->whereIn('status', ['open','pending'])->count() }}</p>
            </div>
            <x-lucide-flag class="w-8 h-8 text-orange-600"/>
        </div>

        <div class="p-6 border rounded-lg shadow bg-white flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Completed</p>
                <p class="text-2xl text-gray-900">{{ $requests->where('status', 'completed')->count() }}</p>
            </div>
            <x-lucide-check-circle class="w-8 h-8 text-green-600"/>
        </div>

        <div class="p-6 border rounded-lg shadow bg-white flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Residents</p>
                <p class="text-2xl text-gray-900">{{ $residents->count() }}</p>
            </div>
            <x-lucide-users class="w-8 h-8 text-primary"/>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <ul class="flex border-b mb-6">
        <li class="-mb-px mr-1">
            <a href="#requests" class="bg-white inline-block py-2 px-4 font-semibold">Requests</a>
        </li>
        <li class="mr-1">
            <a href="#complaints" class="bg-white inline-block py-2 px-4">Complaints</a>
        </li>
        <li class="mr-1">
            <a href="#residents" class="bg-white inline-block py-2 px-4">Residents</a>
        </li>
        <li class="mr-1">
            <a href="#announcements" class="bg-white inline-block py-2 px-4">Announcements</a>
        </li>
        <li class="mr-1">
            <a href="#messages" class="bg-white inline-block py-2 px-4">Messages</a>
        </li>
    </ul>

    {{-- Requests Tab --}}
    <div id="requests" class="space-y-6">
        <div class="p-6 border rounded-lg shadow bg-white">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Request Management</h2>
                <div class="flex gap-2">
                    <button class="px-3 py-1 border rounded">Filter</button>
                    <button class="px-3 py-1 border rounded">Search</button>
                </div>
            </div>

            <div class="space-y-4">
                @foreach($requests as $req)
                <div class="p-4 border rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <p class="font-medium text-gray-900">{{ $req->type }}</p>
                            <p class="text-sm text-gray-600">{{ $req->id }} • {{ $req->resident->name }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded 
                            @if($req->status=='completed') bg-green-100 text-green-800 
                            @elseif($req->status=='processing') bg-blue-100 text-blue-800 
                            @elseif($req->status=='pending') bg-yellow-100 text-yellow-800 
                            @endif">
                            {{ ucfirst($req->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600 mb-3">
                        <div>
                            <span class="font-medium">Submitted:</span><br>
                            {{ \Carbon\Carbon::parse($req->date_submitted)->format('M d, Y') }}
                        </div>
                        <div>
                            <span class="font-medium">Purpose:</span><br>
                            {{ $req->purpose }}
                        </div>
                        @if($req->date_completed)
                        <div>
                            <span class="font-medium">Completed:</span><br>
                            {{ \Carbon\Carbon::parse($req->date_completed)->format('M d, Y') }}
                        </div>
                        @endif
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('requests.show', $req->id) }}" class="px-3 py-1 border rounded">View</a>
                        @if($req->status=='pending')
                            <form method="POST" action="{{ route('requests.update', $req->id) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="processing">
                                <button class="px-3 py-1 bg-blue-500 text-white rounded">Start Processing</button>
                            </form>
                        @elseif($req->status=='processing')
                            <form method="POST" action="{{ route('requests.update', $req->id) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button class="px-3 py-1 bg-green-500 text-white rounded">Mark Complete</button>
                            </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
