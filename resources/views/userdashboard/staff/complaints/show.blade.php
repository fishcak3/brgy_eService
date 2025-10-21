@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Complaint Details</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <p><strong>Reference No:</strong> {{ $complaint->reference_no }}</p>
        <p><strong>Title:</strong> {{ $complaint->title }}</p>
        <p><strong>Type:</strong> {{ $complaint->complaintType->name ?? 'N/A' }}</p>
        <p><strong>Resident:</strong> {{ $complaint->resident->name ?? 'Unknown' }}</p>
        <p><strong>Location:</strong> {{ $complaint->location }}</p>
        <p><strong>Priority:</strong> {{ ucfirst($complaint->priority) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($complaint->status) }}</p>
        <p><strong>Assigned Staff:</strong> {{ $complaint->staff->name ?? 'Unassigned' }}</p>
        <p><strong>Details:</strong> {{ $complaint->details }}</p>
        <p><strong>Remarks:</strong> {{ $complaint->remarks ?? 'N/A' }}</p>
    </div>

    {{-- Update Complaint Status Form --}}
    <div class="mt-6 bg-gray-50 p-4 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-3">Update Complaint Status</h2>
        <form method="POST" action="{{ route('staff.complaints.updateStatus', $complaint->id) }}">
            @csrf

            <div class="mb-3">
                <label class="block font-semibold">Status</label>
                <select name="status" class="w-full border rounded p-2">
                    <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in-progress" {{ $complaint->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="block font-semibold">Remarks</label>
                <textarea name="remarks" class="w-full border rounded p-2" rows="3">{{ old('remarks', $complaint->remarks) }}</textarea>
            </div>

            <button type="submit" 
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Update Complaint
            </button>
        </form>
    </div>
</div>
@endsection
