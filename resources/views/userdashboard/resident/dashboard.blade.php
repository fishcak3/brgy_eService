{{-- resources/views/resident.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Welcome Header --}}
    <div class="mb-8">
        <h1 class="text-3xl text-gray-900 mb-2">Welcome back, {{ Auth::user()->name ?? 'Resident' }}!</h1>
        <p class="text-gray-600">Manage your barangay services and stay updated with community news.</p>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-sm text-gray-600">Total Requests</p>
            <p class="text-2xl text-gray-900">{{ count($requests ?? []) }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-sm text-gray-600">Complaints</p>
            <p class="text-2xl text-gray-900">{{ count($complaints ?? []) }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-sm text-gray-600">Completed</p>
            <p class="text-2xl text-gray-900">
                {{ collect($requests ?? [])->where('status', 'completed')->count() }}
            </p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-sm text-gray-600">Resolved</p>
            <p class="text-2xl text-gray-900">
                {{ collect($complaints ?? [])->where('status', 'resolved')->count() }}
            </p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        {{-- Left Column: Requests & Complaints --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Requests --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Recent Requests</h2>
                <div class="space-y-4">
                    @foreach($requests ?? [] as $req)
                        <div class="flex justify-between items-center p-4 border rounded-lg">
                            <div>
                                <p class="font-medium">{{ $req->type }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $req->id }} • Submitted {{ \Carbon\Carbon::parse($req->dateSubmitted)->format('M d, Y') }}
                                </p>
                                <p class="text-sm text-gray-600">Purpose: {{ $req->purpose }}</p>
                            </div>
                            <div>
                                <span class="px-2 py-1 text-xs rounded 
                                    @if($req->status == 'completed') bg-green-100 text-green-700 
                                    @elseif($req->status == 'processing') bg-blue-100 text-blue-700
                                    @else bg-yellow-100 text-yellow-700 @endif">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Complaints --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">My Complaints</h2>
                <div class="space-y-4">
                    @foreach($complaints ?? [] as $comp)
                        <div class="flex justify-between items-center p-4 border rounded-lg">
                            <div>
                                <p class="font-medium">{{ $comp->title }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $comp->id }} • {{ $comp->category }} • 
                                    Submitted {{ \Carbon\Carbon::parse($comp->dateSubmitted)->format('M d, Y') }}
                                </p>
                            </div>
                            <div>
                                <span class="px-2 py-1 text-xs rounded 
                                    @if($comp->status == 'resolved') bg-green-100 text-green-700 
                                    @elseif($comp->status == 'investigating') bg-blue-100 text-blue-700
                                    @elseif($comp->status == 'pending') bg-yellow-100 text-yellow-700 
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($comp->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right Column: Announcements & Events --}}
        <div class="space-y-6">
            {{-- Announcements --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Latest Announcements</h2>
                <div class="space-y-4">
                    @foreach($announcements ?? [] as $a)
                        <div class="p-3 border rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <span class="px-2 py-1 text-xs rounded 
                                    @if($a->priority == 'high') bg-red-100 text-red-700 
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($a->priority) }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($a->date)->format('M d, Y') }}
                                </span>
                            </div>
                            <h4 class="font-medium">{{ $a->title }}</h4>
                            <p class="text-sm text-gray-600">{{ $a->content }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Events --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Upcoming Events</h2>
                <div class="space-y-4">
                    @foreach($events ?? [] as $e)
                        <div class="p-3 border rounded-lg">
                            <h4 class="font-medium">{{ $e->title }}</h4>
                            <p class="text-sm text-gray-600">📅 {{ \Carbon\Carbon::parse($e->date)->format('M d, Y') }}</p>
                            <p class="text-sm text-gray-600">🕒 {{ $e->time }}</p>
                            <p class="text-sm text-gray-600">📍 {{ $e->venue }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
