@extends('layouts.app')

@section('content')
<div class="p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

    {{-- Requests --}}
    <h2 class="text-xl font-semibold mb-2">All Requests</h2>
    <ul class="mb-6">
        @isset($requests)
            @forelse ($requests as $request)
                <li class="p-2 border-b">
                    {{ $request->title ?? 'Untitled Request' }} 
                    <span class="text-sm text-gray-500">by User #{{ $request->user_id ?? '?' }}</span>
                </li>
            @empty
                <li class="p-2 text-gray-500">No requests found.</li>
            @endforelse
        @else
            <li class="p-2 text-gray-500">Requests data not available.</li>
        @endisset
    </ul>

    {{-- Complaints --}}
    <h2 class="text-xl font-semibold mb-2">All Complaints</h2>
    <ul class="mb-6">
        @isset($complaints)
            @forelse ($complaints as $complaint)
                <li class="p-2 border-b">
                    {{ $complaint->details ?? 'No details provided' }} 
                    <span class="text-sm text-gray-500">(Status: {{ $complaint->status ?? 'N/A' }})</span>
                </li>
            @empty
                <li class="p-2 text-gray-500">No complaints found.</li>
            @endforelse
        @else
            <li class="p-2 text-gray-500">Complaints data not available.</li>
        @endisset
    </ul>

    {{-- Announcements --}}
    <h2 class="text-xl font-semibold mb-2">Latest Announcements</h2>
    <ul>
        @isset($announcements)
            @forelse ($announcements as $announcement)
                <li class="p-2 border-b">
                    {{ $announcement->title ?? 'Untitled' }} 
                    <span class="text-sm text-gray-500">{{ $announcement->created_at->diffForHumans() ?? '' }}</span>
                </li>
            @empty
                <li class="p-2 text-gray-500">No announcements available.</li>
            @endforelse
        @else
            <li class="p-2 text-gray-500">Announcements data not available.</li>
        @endisset
    </ul>
</div>
@endsection
