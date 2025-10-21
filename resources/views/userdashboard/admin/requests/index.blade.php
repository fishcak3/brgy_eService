@extends('layouts.sidebar')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-700">Manage Requests</h1>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Form --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-5">
        <div class="w-full sm:w-1/4">
            <select name="type" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                <option value="">All Types</option>
                <option value="Certificate" {{ request('type') == 'Certificate' ? 'selected' : '' }}>Certificate</option>
                <option value="Permit" {{ request('type') == 'Permit' ? 'selected' : '' }}>Permit</option>
                <option value="Service" {{ request('type') == 'Service' ? 'selected' : '' }}>Service</option>
            </select>
        </div>

        <div class="w-full sm:w-1/4">
            <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                <option value="">All Statuses</option>
                @foreach(['pending','assigned','processing','completed','rejected'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                Filter
            </button>
            <a href="{{ route('admin.requests.index') }}"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                Reset
            </a>
        </div>
    </form>

    {{-- Requests Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Applicant</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date Submitted</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Assigned To</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($requests as $req)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm text-gray-800">{{ $req->requestType->name ?? 'N/A' }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $req->resident->full_name ?? 'N/A' }}</td>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $req->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-3 text-sm">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'open' => 'bg-blue-100 text-blue-700',
                                    'assigned' => 'bg-blue-100 text-blue-700',
                                    'processing' => 'bg-indigo-100 text-indigo-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$req->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($req->status) }}
                            </span>
                        </td>

                        {{-- Dropdown for Assigned Staff --}}
                        <td class="px-6 py-3 text-sm text-gray-700">
                            <form method="POST" action="{{ route('admin.requests.update', $req->id) }}">
                                @csrf
                                @method('PUT')
                                <select name="assigned_to" onchange="this.form.submit()"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 text-sm">
                                    <option value="">Unassigned</option>
                                    @foreach($officials as $official)
                                        <option value="{{ $official->id }}" {{ $req->assigned_to == $official->id ? 'selected' : '' }}>
                                            {{ $official->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="status" value="assigned">
                            </form>
                        </td>
                        <td class="px-6 py-3 text-sm text-right">
                            <a href="{{ route('admin.requests.show', $req->id) }}"
                                class="text-green-600 hover:text-green-800 font-semibold">
                                View
                            </a>
                        </td>
                    </tr>

                    {{-- Expandable Details Section --}}
                    <tr id="details-{{ $req->id }}" class="hidden bg-gray-50">
                        <td colspan="6" class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.requests.update', $req->id) }}" class="space-y-3">
                                @csrf
                                @method('PUT')

                                <div class="flex flex-wrap gap-3">
                                    <div class="w-full sm:w-1/3">
                                        <select name="assigned_to" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                                            <option value="">Assign To...</option>
                                            @foreach($officials as $official)
                                                <option value="{{ $official->id }}" {{ $req->assigned_to == $official->id ? 'selected' : '' }}>
                                                    {{ $official->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="w-full sm:w-1/4">
                                        <select name="status" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                                            @foreach(['pending','assigned','processing','completed','rejected'] as $status)
                                                <option value="{{ $status }}" {{ $req->status == $status ? 'selected' : '' }}>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="w-full sm:w-1/4">
                                        <input type="date" name="deadline" value="{{ $req->deadline }}"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                                    </div>
                                </div>

                                <textarea name="notes" rows="2"
                                    placeholder="Add notes..."
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">{{ $req->notes }}</textarea>

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
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $requests->links() }}
    </div>
</div>
@endsection
