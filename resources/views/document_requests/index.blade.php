@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">

    {{-- Back to Dashboard --}}
    <a href="{{ route('resident.dashboard') }}" 
       class="flex items-center text-gray-600 hover:text-green-600 mb-4">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" 
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Dashboard
    </a>

    {{-- Page Header --}}
    <h1 class="text-2xl font-bold text-gray-900">My Requests</h1>
    <p class="text-gray-600 mb-6">View and manage all your document requests and certificates.</p>

    {{-- Search, Filter, and New Request --}}
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-3">
        <div class="flex w-full sm:w-2/3 gap-2">
            <input type="text" placeholder="Search requests..." 
                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
            
            <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
                <option>All Status</option>
                <option>Completed</option>
                <option>Processing</option>
                <option>Pending</option>
                <option>Rejected</option>
            </select>
        </div>

        <a href="{{ route('document-requests.create') }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
            + New Request
        </a>
    </div>

    {{-- Requests List --}}
    <div class="space-y-4">
        @foreach($requests as $request)
            <div class="bg-white shadow rounded-lg p-4 flex justify-between items-center">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">
                        {{ $request->requestType->name ?? 'Unknown Request' }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ $request->created_at?->format('M d, Y') ?? 'N/A' }}
                    </p>
                    <p class="text-sm text-gray-500">Purpose: {{ $request->details }}</p>

                    @if($request->status === 'rejected')
                        <p class="text-sm text-red-600 mt-1">Reason: {{ $request->remarks }}</p>
                    @endif
                </div>

                {{-- Status + Actions --}}
                <div class="flex items-center space-x-3">
                    @php
                        $statusColors = [
                            'completed'  => 'text-green-600 bg-green-100',
                            'processing' => 'text-yellow-600 bg-yellow-100',
                            'pending'    => 'text-orange-600 bg-orange-100',
                            'rejected'   => 'text-red-600 bg-red-100',
                        ];
                    @endphp
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$request->status] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($request->status) }}
                    </span>

                    {{-- Action Buttons --}}
                    <a href="{{ route('document-requests.show', $request->id) }}" 
                       class="text-gray-600 hover:text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" 
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>

                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
