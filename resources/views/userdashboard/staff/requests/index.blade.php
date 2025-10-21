@extends('layouts.sidebar')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manage Requests</h1>
        <p class="text-gray-600">Track, process, and update resident service requests.</p>

        <a href="{{ route('staff.requests.create') }}" class="btn btn-success mb-3">Create Request</a>

    </div>

    {{-- Summary Counters --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-summary-card title="Pending Requests" :value="$pendingRequests" icon="heroicon-o-clock" color="yellow" />
        <x-summary-card title="Approved Today" :value="$approvedToday" icon="heroicon-o-check-circle" color="green" />
        <x-summary-card title="Completed This Month" :value="$completedThisMonth" icon="heroicon-o-clipboard-check" color="blue" />
        <x-summary-card title="Overdue Requests" :value="$overdueRequests" icon="heroicon-o-exclamation-circle" color="red" />
    </div>

   {{-- Filters & Search --}}
    <div class="bg-white p-4 rounded-xl shadow mb-6">
        <form method="GET" action="{{ route('staff.requests.index') }}" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            {{-- Filters --}}
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 w-full">
                {{-- Date Range --}}
                <select name="date_range" class="border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Date Range</option>
                    <option value="7_days" {{ request('date_range') == '7_days' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>This Month</option>
                    <option value="3_months" {{ request('date_range') == '3_months' ? 'selected' : '' }}>Last 3 Months</option>
                </select>

                {{-- Category --}}
                <select name="category" class="border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Category</option>
                    <option value="Barangay Clearance" {{ request('category') == 'Barangay Clearance' ? 'selected' : '' }}>Barangay Clearance</option>
                    <option value="Certificate of Residency" {{ request('category') == 'Certificate of Residency' ? 'selected' : '' }}>Certificate of Residency</option>
                    <option value="Certificate of Indigency" {{ request('category') == 'Certificate of Indigency' ? 'selected' : '' }}>Certificate of Indigency</option>
                    <option value="Business Permit" {{ request('category') == 'Business Permit' ? 'selected' : '' }}>Business Permit</option>
                </select>

                {{-- Status --}}
                <select name="status" class="border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>

                {{-- Priority --}}
                <select name="priority" class="border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Priority</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
            </div>

            {{-- Search Bar --}}
            <div class="w-full md:w-1/3">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Ref No., Name, or Keywords"
                        class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500 pr-10" />
                    <button type="submit" class="absolute right-2 top-2 text-gray-500 hover:text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Requests Table --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Reference ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Resident</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">SLA Due</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Requested</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Assigned</th>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($requests as $req)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $req->reference_no }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $req->requestType->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $req->resident->name ?? 'Unknown' }}
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <span class="px-2 py-1 text-xs rounded 
                                @if($req->status === 'New') bg-blue-100 text-blue-800
                                @elseif($req->status === 'For Validation') bg-yellow-100 text-yellow-800
                                @elseif($req->status === 'Completed') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $req->status }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ \Carbon\Carbon::parse($req->needed_date)->format('M d') }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ \Carbon\Carbon::parse($req->requested_date)->format('M d') }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            ₱{{ number_format($req->fee ?? 0, 2) }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $req->assignedStaff->name ?? 'Unassigned' }}
                        </td>
                        <td class="px-4 py-2 text-right text-sm">
                            <a href="{{ 'requests.show' }}" class="text-blue-600 hover:text-blue-900">Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-2 text-center text-gray-500">No requests found.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>
@endsection
