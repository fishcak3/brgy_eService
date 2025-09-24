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
            <p class="text-2xl text-gray-900">{{ $requests->count() }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-sm text-gray-600">Complaints</p>
            <p class="text-2xl text-gray-900">{{ $complaints->count() }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-sm text-gray-600">Completed</p>
            <p class="text-2xl text-gray-900">{{ $requests->where('status', 'completed')->count() }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-sm text-gray-600">Resolved</p>
            <p class="text-2xl text-gray-900">{{ $complaints->where('status', 'resolved')->count() }}</p>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Left Section --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Services & Reports --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Services & Reports</h2>

                {{-- Recent Requests --}}
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold">Recent Requests</h3>
                    <a href="{{ route('document-requests.create') }}" 
                       class="px-3 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600">
                        + New Request
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($requests as $req)
                        <div class="flex justify-between items-center p-4 border rounded-lg">
                            <div>
                                <p class="font-medium">{{ $req->requestType->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">
                                    Ref: {{ $req->reference_no }} • 
                                    Submitted {{ $req->created_at->format('M d, Y') }}
                                </p>
                                @if($req->details)
                                    <p class="text-sm text-gray-600">Details: {{ $req->details }}</p>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 text-xs rounded 
                                    @if($req->status == 'completed') bg-green-100 text-green-700
                                    @elseif($req->status == 'processing') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No requests yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Profile Summary --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Profile Summary</h2>
                <div class="grid sm:grid-cols-2 gap-4 text-sm text-gray-700">
                    <p><span class="font-medium">Full Name:</span> {{ Auth::user()->name }}</p>
                    <p><span class="font-medium">Email:</span> {{ Auth::user()->email }}</p>
                    {{-- If you add resident_id or address fields in users table, use them here --}}
                </div>
                <a href="{{ route('profile.edit') }}" 
                   class="mt-4 inline-block px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 text-sm">
                    Update Profile
                </a>
            </div>
        </div>

        {{-- Right Section --}}
        <div class="space-y-6">
            {{-- Announcements --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Latest Announcements</h2>
                <div class="space-y-4">
                    @forelse($announcements as $a)
                        <div class="p-3 border rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <span class="px-2 py-1 text-xs rounded 
                                    @if($a->priority == 'high') bg-red-100 text-red-700
                                    @elseif($a->priority == 'medium') bg-green-100 text-green-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($a->priority) }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ $a->published_at?->format('M d, Y') }}
                                </span>
                            </div>
                            <h4 class="font-medium">{{ $a->title }}</h4>
                            <p class="text-sm text-gray-600">{{ $a->content }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No announcements yet.</p>
                    @endforelse
                </div>
                <a href="#">View All Announcements</a>
            </div>
        </div>
    </div>
</div>
@endsection
