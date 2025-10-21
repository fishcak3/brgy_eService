@extends('layouts.sidebar')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-700">Manage Complaints</h1>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Section --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-5">
        <div class="w-full sm:w-1/3">
            <select name="status" onchange="this.form.submit()"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                <option value="">Filter by Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>

        <div class="w-full sm:w-1/3">
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="Search by resident or subject..."
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
        </div>

        <div class="flex gap-2">
            <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                Apply
            </button>
            <a href="{{ route('admin.complaints.index') }}"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                Reset
            </a>
        </div>
    </form>

    {{-- Table Section --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Resident</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date Filed</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Assigned To</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($complaints as $complaint)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3 text-sm font-medium text-gray-800">
                            {{ $complaint->resident->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-600">
                            {{ Str::limit($complaint->details, 40) }}
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-600">
                            {{ $complaint->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-3 text-sm">
                            @if($complaint->status == 'open')
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">Open</span>
                            @elseif($complaint->status == 'assigned')
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">Assigned</span>
                            @elseif($complaint->status == 'in-progress')
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">In Progress</span>
                            @elseif($complaint->status == 'resolved')
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Resolved</span>
                            @elseif($complaint->status == 'rejected')
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">Rejected</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">Unknown</span>
                            @endif
                        </td>

                        <td class="px-6 py-3 text-sm text-gray-700">
                            <form method="POST" action="{{ route('admin.complaints.update', $complaint->id) }}" onchange="this.submit()">
                                @csrf
                                @method('PUT')
                                <select name="assigned_to"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 text-sm">
                                    <option value="">Unassigned</option>
                                    @foreach($staff as $official)
                                        <option value="{{ $official->id }}" 
                                            {{ $complaint->assigned_to == $official->id ? 'selected' : '' }}>
                                            {{ $official->full_name }}
                                        </option>
                                    @endforeach
                                </select>

                                {{-- Hidden field to change status automatically --}}
                                @if(empty($complaint->assigned_to))
                                    <input type="hidden" name="status" value="assigned">
                                @endif
                            </form>
                        </td>
                        <td class="px-6 py-3 text-sm text-right">
                            <a href="{{ route('admin.complaints.show', $complaint->id) }}"
                                class="text-green-600 hover:text-green-800 font-semibold">
                                View
                            </a>
                        </td>
                    </tr>

                    {{-- Expandable Details Section --}}
                    <tr id="details-{{ $complaint->id }}" class="hidden bg-gray-50">
                        <td colspan="7" class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.complaints.update', $complaint->id) }}" class="space-y-3">
                                @csrf
                                @method('PUT')

                                <div class="flex flex-wrap gap-3">
                                    <div class="w-full sm:w-1/3">
                                        <select name="assigned_to" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                                            <option value="">Assign To...</option>
                                            @foreach($staff as $member)
                                                <option value="{{ $member->id }}" {{ $complaint->assigned_to == $member->id ? 'selected' : '' }}>
                                                    {{ $member->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="w-full sm:w-1/4">
                                        <select name="status" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                                            @foreach(['open','assigned','in-progress','resolved','rejected'] as $status)
                                                <option value="{{ $status }}" {{ $complaint->status == $status ? 'selected' : '' }}>
                                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="w-full sm:w-1/4">
                                        <input type="date" name="resolved_at" 
                                            value="{{ $complaint->resolved_at ? \Carbon\Carbon::parse($complaint->resolved_at)->format('Y-m-d') : '' }}"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                                    </div>
                                </div>

                                <textarea name="remarks" rows="2"
                                    placeholder="Add remarks..."
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">{{ $complaint->remarks }}</textarea>

                                <div class="flex justify-end">
                                    <button type="submit" 
                                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No complaints found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $complaints->links() }}
    </div>
</div>
@endsection
