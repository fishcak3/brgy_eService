@extends('layouts.sidebar')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Complaint Management</h1>
        <p class="text-gray-600">Track, process, and resolve community complaints efficiently.</p>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-summary-card title="New Complaints" :value="$summary['new'] ?? 0" icon="heroicon-o-inbox" color="indigo"/>
        <x-summary-card title="In Progress" :value="$summary['in_progress'] ?? 0" icon="heroicon-o-clock" color="yellow"/>
        <x-summary-card title="Resolved" :value="$summary['resolved'] ?? 0" icon="heroicon-o-check-circle" color="green"/>
        <x-summary-card title="Rejected" :value="$summary['rejected'] ?? 0" icon="heroicon-o-x-circle" color="red"/>
    </div>


    {{-- Filters & Search --}}
    <div class="bg-white p-4 rounded-xl shadow mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 w-full">
                <select class="border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option>Date Range</option>
                    <option>Last 7 Days</option>
                    <option>This Month</option>
                    <option>Last 3 Months</option>
                </select>
                <select class="border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option>Category</option>
                    <option>Noise</option>
                    <option>Sanitation</option>
                    <option>Disputes</option>
                    <option>Public Safety</option>
                </select>
                <select class="border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option>Status</option>
                    <option>New</option>
                    <option>Under Investigation</option>
                    <option>Pending Resolution</option>
                    <option>Resolved</option>
                </select>
                <select class="border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option>Priority</option>
                    <option>Low</option>
                    <option>Medium</option>
                    <option>High</option>
                    <option>Urgent</option>
                </select>
            </div>

            <div class="w-full md:w-1/3">
                <input type="text" placeholder="Search by Ref No., Name, or Keywords"
                       class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500" />
            </div>
        </div>
    </div>

    {{-- Complaints Table --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Reference No.</th>
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">Category</th>
                    <th class="px-6 py-3">Resident</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Priority</th>
                    <th class="px-6 py-3">Date Filed</th>
                    <th class="px-6 py-3">Last Updated</th>
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @forelse ($complaints as $complaint)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $complaint->reference_no }}</td>
                    <td class="px-6 py-4">{{ $complaint->type->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $complaint->user->name ?? 'Unknown Resident' }}</td>
                    <td class="px-6 py-4">{{ ucfirst($complaint->status) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($complaint->priority === 'urgent') bg-red-200 text-red-700
                            @elseif($complaint->priority === 'high') bg-orange-200 text-orange-700
                            @elseif($complaint->priority === 'medium') bg-yellow-200 text-yellow-700
                            @else bg-green-200 text-green-700
                            @endif">
                            {{ ucfirst($complaint->priority) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $complaint->location ?? '—' }}</td>
                    <td class="px-6 py-4">{{ $complaint->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4">{{ optional($complaint->resolved_at)->format('Y-m-d') ?? '—' }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('staff.complaints.show', $complaint->id) }}"
                        class="text-indigo-600 hover:text-indigo-800 font-medium">View Details</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-gray-500 py-4">No complaints found.</td>
                </tr>
            @endforelse
        </tbody>

        </table>
    </div>

</div>
@endsection
