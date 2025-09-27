@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- Back Navigation --}}
    <a href="{{ route('resident.dashboard') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">
        ← Back to Dashboard
    </a>

    {{-- Page Header --}}
    <h1 class="text-2xl font-bold text-gray-900">My Complaints</h1>
    <p class="text-gray-600 mb-6">View and track all your submitted complaints and their resolution status.</p>

    {{-- Filters --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <input type="text" placeholder="Search complaints..."
                   class="w-full sm:w-64 rounded-lg border-gray-300 focus:ring focus:ring-blue-200 text-sm" />
            <select class="rounded-lg border-gray-300 text-sm">
                <option>All Status</option>
                <option>Resolved</option>
                <option>Pending</option>
                <option>Investigating</option>
            </select>
            <select class="rounded-lg border-gray-300 text-sm">
                <option>All Categories</option>
                <option>Infrastructure</option>
                <option>Sanitation</option>
                <option>Utilities</option>
            </select>
        </div>
        <a href="{{ route('complaints.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
            File New Complaint
        </a>
    </div>

    {{-- Complaints List --}}
    <h2 class="text-lg font-semibold mb-4">All Complaints ({{ $complaints->count() }})</h2>

    <div class="space-y-4">
        @forelse($complaints as $complaint)
            <div class="bg-white rounded-xl shadow p-4 flex items-start justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900">
                        {{ $complaint->title }}
                        <span class="ml-2 text-xs px-2 py-1 rounded-full
                            @if($complaint->priority === 'high') bg-red-100 text-red-600
                            @elseif($complaint->priority === 'medium') bg-yellow-100 text-yellow-600
                            @elseif($complaint->priority === 'low') bg-green-100 text-green-600
                            @else bg-gray-100 text-gray-600 @endif">
                            {{ ucfirst($complaint->priority) }}
                        </span>
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ $complaint->reference_no }} • {{ $complaint->category }} •
                        Submitted {{ $complaint->created_at->format('m/d/Y') }}
                    </p>
                    @if($complaint->location)
                        <p class="text-sm text-gray-400 mt-1">📍 {{ $complaint->location }}</p>
                    @endif
                </div>

                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 text-xs rounded-full 
                        @if($complaint->status === 'resolved') bg-green-100 text-green-600
                        @elseif($complaint->status === 'pending') bg-yellow-100 text-yellow-600
                        @elseif($complaint->status === 'investigating') bg-orange-100 text-orange-600
                        @else bg-blue-100 text-blue-600 @endif">
                        {{ ucfirst($complaint->status) }}
                    </span>
                    <a href="{{ route('complaints.show', $complaint->id) }}"
                       class="text-gray-500 hover:text-gray-700">
                        👁
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No complaints found.</p>
        @endforelse
    </div>
</div>
@endsection
