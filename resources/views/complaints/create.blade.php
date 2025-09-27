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
    <h1 class="text-2xl font-bold text-gray-900 mb-1">File a Complaint</h1>
    <p class="text-gray-600 mb-6">
        Report issues and concerns to Barangay Bakitiw officials
    </p>

    {{-- Complaint Form --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center mb-4">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" stroke-width="2" 
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M12 8c.414 0 .75-.336.75-.75S12.414 6.5 12 6.5s-.75.336-.75.75.336.75.75.75zm0 8v-4m-9 4a9 9 0 1118 0H3z" />
            </svg>
            Complaint Form
        </h2>

        <form action="{{ route('complaints.store') }}" method="POST">
            @csrf

            {{-- Complaint Title --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Complaint Title *</label>
                <input type="text" name="title" required
                       placeholder="Brief title describing your complaint"
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>

            {{-- Category --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Category *</label>
                <select name="complaint_type_id" required
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">Select complaint category</option>
                    @foreach($complaintTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Location --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" 
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M12 11c.828 0 1.5-.672 1.5-1.5S12.828 8 12 8s-1.5.672-1.5 1.5S11.172 11 12 11z" />
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M12 22s8-7.333 8-13A8 8 0 004 9c0 5.667 8 13 8 13z" />
                    </svg>
                    Location
                </label>
                <input type="text" name="location"
                       placeholder="Specific location or address where the issue occurred"
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>

            {{-- Priority Level --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Priority Level</label>
                <select name="priority"
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="low">Low - Minor concern</option>
                    <option value="medium" selected>Medium - Moderate concern</option>
                    <option value="high">High - Major concern</option>
                    <option value="urgent">Urgent - Immediate action required</option>
                </select>
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Description *</label>
                <textarea name="details" rows="4" required
                          placeholder="Provide a detailed description of your complaint. Include what happened, when it occurred, and any other relevant information."
                          class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
            </div>

            {{-- Contact Information --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" 
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M3 5h2l3.6 7.59-1.35 2.44A1 1 0 008 17h8a1 1 0 00.9-.55l3.24-6.49A1 1 0 0019 9H6" />
                    </svg>
                    Contact Information
                </label>
                <input type="text" name="contact_info"
                       placeholder="Phone number for follow-up communications"
                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>

            {{-- Next Steps Info --}}
            <div class="mb-4 p-3 border rounded bg-green-50 text-sm text-gray-700">
                <p class="font-medium mb-1">What happens next?</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Your complaint will be reviewed by barangay staff within 24 hours</li>
                    <li>You will receive updates on the status through the system</li>
                    <li>Appropriate action will be taken based on the nature of your complaint</li>
                    <li>High priority complaints are addressed immediately</li>
                </ul>
            </div>

            {{-- Confidentiality Notice --}}
            <div class="mb-6 p-3 border rounded bg-gray-50 text-sm text-gray-600 flex items-start">
                <svg class="w-5 h-5 text-gray-500 mr-2 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" 
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M13 16h-1v-4h-1m1-4h.01M12 19a7 7 0 100-14 7 7 0 000 14z" />
                </svg>
                All complaints are treated confidentially and reviewed by authorized barangay personnel. 
                False or malicious complaints may result in legal consequences.
            </div>

            {{-- Buttons --}}
            <div class="flex space-x-3">
                <button type="submit" 
                        class="flex-1 py-2 bg-green-600 text-white font-medium rounded hover:bg-green-700">
                    Submit Complaint
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
