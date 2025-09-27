@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">
        Request Details
    </h2>

    <p><strong>Reference No:</strong> {{ $documentRequest->reference_no }}</p>
    <p><strong>Request Type:</strong> {{ $documentRequest->requestType->name ?? 'N/A' }}</p>
    <p><strong>Purpose:</strong> {{ $documentRequest->details }}</p>
    <p><strong>Priority:</strong> {{ ucfirst($documentRequest->priority) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($documentRequest->status) }}</p>
    <p><strong>Requested Date:</strong> {{ $documentRequest->requested_date->format('F d, Y') }}</p>
    <p><strong>Additional Details:</strong> {{ $documentRequest->details ?? 'None' }}</p>

    <div class="mt-4">
        <a href="{{ route('document-requests.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded">
           Back
        </a>
    </div>
</div>
@endsection
