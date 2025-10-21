@extends('layouts.sidebar')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-green-700 mb-4">Request Details</h1>

    <div class="space-y-3">
        <p><strong>Reference No:</strong> {{ $documentRequest->reference_no }}</p>
        <p><strong>Resident:</strong> {{ $documentRequest->resident->full_name ?? 'N/A' }}</p>
        <p><strong>Request Type:</strong> {{ $documentRequest->requestType->name ?? 'N/A' }}</p>
        <p><strong>Priority:</strong> {{ ucfirst($documentRequest->priority) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($documentRequest->status) }}</p>
        <p><strong>Assigned To:</strong> {{ $documentRequest->staff->full_name ?? 'Unassigned' }}</p>
        <p><strong>Date Submitted:</strong> {{ $documentRequest->created_at->format('M d, Y h:i A') }}</p>
        <p><strong>Needed Date:</strong> {{ $documentRequest->needed_date ? \Carbon\Carbon::parse($documentRequest->needed_date)->format('M d, Y') : 'Not specified' }}</p>

        <hr class="my-4">

        <p><strong>Details:</strong></p>
        <div class="border p-3 rounded text-gray-700 bg-gray-50">
            {{ $documentRequest->details ?? 'No details provided.' }}
        </div>

        <p><strong>Remarks:</strong></p>
        <div class="border p-3 rounded text-gray-700 bg-gray-50">
            {{ $documentRequest->remarks ?? 'No remarks yet.' }}
        </div>

        <p><strong>Fee:</strong> ₱{{ number_format($documentRequest->fee, 2) }}</p>
        <p><strong>Source:</strong> {{ $documentRequest->source ?? 'N/A' }}</p>
    </div>

    <div class="mt-6 flex gap-2">
        <a href="{{ route('admin.requests.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">
            Back
        </a>
    </div>
</div>
@endsection
