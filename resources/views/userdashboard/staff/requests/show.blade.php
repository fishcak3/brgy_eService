@extends('layouts.sidebar')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Request Details</h1>
        <p class="text-gray-600">Review and update the status of this request.</p>
    </div>

    {{-- Request Information --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Request Information</h2>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Reference No.</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $request->reference_no ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Request Type</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $request->requestType->name ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Resident</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $request->user->name ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Requested Date</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $request->requested_date->format('M d, Y') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Needed Date</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $request->needed_date ? $request->needed_date->format('M d, Y') : 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Current Status</dt>
                <dd class="mt-1 text-sm">
                    <span class="px-2 py-1 rounded text-xs font-medium 
                        @if($request->status == 'pending') bg-yellow-100 text-yellow-700
                        @elseif($request->status == 'approved') bg-green-100 text-green-700
                        @elseif($request->status == 'rejected') bg-red-100 text-red-700
                        @else bg-gray-100 text-gray-700
                        @endif">
                        {{ ucfirst($request->status) }}
                    </span>
                </dd>
            </div>
        </dl>
    </div>

    {{-- Update Form --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Update Status</h2>
        <form action="{{ route('staff.requests.updateStatus', $request->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $request->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="approved" {{ $request->status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                <textarea id="remarks" name="remarks" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                    placeholder="Add remarks here (optional)...">{{ old('remarks', $request->remarks) }}</textarea>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('staff.requests.index') }}" 
                   class="text-gray-600 hover:underline text-sm">← Back to Requests</a>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700">
                    Update Request
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
