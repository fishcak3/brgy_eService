@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6 px-4">
    {{-- Back to Dashboard --}}
    <a href="{{ route('resident.dashboard') }}" 
       class="flex items-center text-gray-600 hover:text-green-600 mb-4">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" 
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Dashboard
    </a>

    {{-- Page Title --}}
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Submit New Request</h1>
    <p class="text-gray-600 mb-6">
        Request official documents and certificates from Barangay Bakitiw
    </p>

    {{-- Form Card --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center mb-4">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" stroke-width="2" 
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M12 8c.414 0 .75-.336.75-.75S12.414 6.5 12 6.5s-.75.336-.75.75.336.75.75.75zm0 8v-4m-9 4a9 9 0 1118 0H3z" />
            </svg>
            Document Request Form
        </h2>

        <form action="{{ route('document-requests.store') }}" method="POST">
            @csrf

            {{-- Document Type --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Document Type *</label>
                <select name="request_type_id" required
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">Select document type</option>
                    @foreach($requestTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Purpose --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Purpose *</label>
                <input type="text" name="purpose" required
                       placeholder="e.g., Employment, Bank Requirements, School Enrollment"
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>

            {{-- Additional Details --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Additional Details</label>
                <textarea name="additional_details"
                          placeholder="Any additional information or special requirements"
                          class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
            </div>

            {{-- Priority Level --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Priority Level</label>
                <select name="priority_level"
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="low">Low</option>
                    <option value="medium" selected>Normal (3-5 business days)</option>
                    <option value="high">High</option>
                    <option value="urgent">Urgent (1-2 business days)</option>
                </select>
            </div>

            {{-- Info Box --}}
            <div class="mb-4 p-3 border rounded bg-gray-50 text-sm text-gray-600 flex items-start">
                <svg class="w-5 h-5 text-gray-500 mr-2 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" 
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M13 16h-1v-4h-1m1-4h.01M12 19a7 7 0 100-14 7 7 0 000 14z" />
                </svg>
                Make sure all information is accurate. Processing time may vary based on document verification requirements. 
                You will receive notifications about your request status through the system.
            </div>

            {{-- Required Documents --}}
            <div class="mb-6 p-3 border rounded bg-green-50 text-sm text-gray-700">
                <p class="font-medium mb-1">Required Documents to Bring:</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Valid ID with photo (original and photocopy)</li>
                    <li>Proof of residency (if applicable)</li>
                    <li>Additional documents based on certificate type</li>
                </ul>
            </div>

            {{-- Buttons --}}
            <div class="flex space-x-3">
                <button type="submit" 
                        class="flex-1 py-2 bg-green-600 text-white font-medium rounded hover:bg-green-700">
                    Submit Request
                </button>
                <a href="{{ route('resident.dashboard') }}" 
                   class="flex-1 py-2 text-center border border-gray-300 rounded text-gray-700 hover:bg-gray-100">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
