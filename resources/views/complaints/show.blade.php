{{-- resources/views/complaints/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">
        Complaint Details
    </h2>

    <p><strong>Reference No:</strong> {{ $complaint->reference_no }}</p>
    <p><strong>Type:</strong> {{ $complaint->complaintType->name ?? 'N/A' }}</p>
    <p><strong>Priority:</strong> {{ ucfirst($complaint->priority ?? 'normal') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($complaint->status) }}</p>
    <p><strong>Details:</strong> {{ $complaint->details }}</p>

    @if($complaint->staff)
        <p><strong>Assigned Staff:</strong> {{ $complaint->staff->name }}</p>
    @endif

    @if($complaint->resolved_at)
        <p><strong>Resolved At:</strong> {{ \Carbon\Carbon::parse($complaint->resolved_at)->format('F d, Y h:i A') }}</p>
    @endif

    <div class="mt-4">
        <a href="{{ route('complaints.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded">
           Back
        </a>
    </div>
</div>
@endsection
