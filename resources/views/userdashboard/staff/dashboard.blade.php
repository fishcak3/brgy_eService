@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl text-gray-900 mb-2">Staff Dashboard</h1>
        <p class="text-gray-600">Welcome, {{ Auth::user()->name }}. Manage barangay services and residents.</p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <x-dashboard.stat label="Pending Requests" 
            count="{{ $requests->where('status','pending')->count() }}" 
            icon="alert-circle" color="text-yellow-600" />

        <x-dashboard.stat label="Processing" 
            count="{{ $requests->where('status','processing')->count() }}" 
            icon="clock" color="text-blue-600" />

        <x-dashboard.stat label="Open Complaints" 
            count="{{ $complaints->whereIn('status',['open','pending'])->count() }}" 
            icon="flag" color="text-orange-600" />

        <x-dashboard.stat label="Completed Today" 
            count="{{ $requests->where('status','completed')->count() }}" 
            icon="check-circle" color="text-green-600" />

        <x-dashboard.stat label="Total Residents" 
            count="{{ $residents->count() }}" 
            icon="users" color="text-indigo-600" />
    </div>

    <!-- Tabs -->
    <div x-data="{ tab: 'requests' }">
        <div class="grid grid-cols-5 mb-6 text-center border-b">
            <button class="py-2" :class="{ 'border-b-2 border-indigo-600 font-medium' : tab === 'requests' }" @click="tab = 'requests'">Document Requests</button>
            <button class="py-2" :class="{ 'border-b-2 border-indigo-600 font-medium' : tab === 'complaints' }" @click="tab = 'complaints'">Manage Complaints</button>
            <button class="py-2" :class="{ 'border-b-2 border-indigo-600 font-medium' : tab === 'residents' }" @click="tab = 'residents'">Resident Records</button>
            <button class="py-2" :class="{ 'border-b-2 border-indigo-600 font-medium' : tab === 'announcements' }" @click="tab = 'announcements'">Announcements</button>
            <button class="py-2" :class="{ 'border-b-2 border-indigo-600 font-medium' : tab === 'messages' }" @click="tab = 'messages'">Staff Messages</button>
        </div>

        <!-- Requests Tab -->
        <div x-show="tab === 'requests'" class="space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Request Management</h2>
                @foreach($requests as $request)
                    <div class="p-4 border rounded-lg mb-4">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="font-medium">{{ $request->type }}</p>
                                <p class="text-sm text-gray-600">{{ $request->id }} • {{ $request->resident->name }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded 
                                @if($request->status=='pending') bg-yellow-100 text-yellow-800
                                @elseif($request->status=='processing') bg-blue-100 text-blue-800
                                @elseif($request->status=='completed') bg-green-100 text-green-800
                                @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600">Submitted: {{ $request->date_submitted->format('M d, Y') }}</p>
                        @if($request->date_completed)
                            <p class="text-sm text-gray-600">Completed: {{ $request->date_completed->format('M d, Y') }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Residents Tab -->
        <div x-show="tab === 'residents'" class="space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Resident Records</h2>
                @foreach($residents as $resident)
                    <div class="p-4 border rounded-lg mb-4 flex justify-between">
                        <div>
                            <p class="font-medium">{{ $resident->name }}</p>
                            <p class="text-sm text-gray-600">{{ $resident->email }}</p>
                            <p class="text-sm text-gray-600">{{ $resident->address }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded 
                            {{ $resident->status == 'verified' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($resident->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Complaints, Announcements, Messages Tabs can follow similar structure -->
    </div>
</div>
@endsection
