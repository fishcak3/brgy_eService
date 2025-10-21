@extends('layouts.sidebar')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-green-700 mb-4">Complaint Details</h1>

    <div class="space-y-3">
        <p><strong>Title:</strong> {{ $complaint->title }}</p>
        <p><strong>Type:</strong> {{ $complaint->complaintType->name ?? 'N/A' }}</p>
        <p><strong>Resident:</strong> {{ $complaint->resident->full_name ?? 'N/A' }}</p>
        <p><strong>Location:</strong> {{ $complaint->location }}</p>
        <p><strong>Priority:</strong> {{ ucfirst($complaint->priority) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($complaint->status) }}</p>
        <p><strong>Assigned To:</strong> {{ $complaint->staff->full_name ?? 'Unassigned' }}</p>
        <p><strong>Details:</strong> {{ $complaint->details }}</p>
        <p><strong>Remarks:</strong> {{ $complaint->remarks ?? 'None' }}</p>
        <p><strong>Date Filed:</strong> {{ $complaint->created_at->format('M d, Y h:i A') }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.complaints.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">
            Back
        </a>
    </div>
</div>
@endsection
