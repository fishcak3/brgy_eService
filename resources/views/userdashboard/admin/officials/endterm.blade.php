@extends('layouts.sidebar')

@section('content')
<div class="p-8 bg-white rounded-lg shadow-md">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-700">Official End Term Management</h1>
        <a href="{{ route('admin.officials.index') }}" class="text-green-600 hover:underline">← Back to Officials</a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">#</th>
                    <th class="px-4 py-3 text-left font-semibold">Full Name</th>
                    <th class="px-4 py-3 text-left font-semibold">Position</th>
                    <th class="px-4 py-3 text-left font-semibold">Term Start</th>
                    <th class="px-4 py-3 text-left font-semibold">Term End</th>
                    <th class="px-4 py-3 text-center font-semibold">Reason</th>
                    <th class="px-4 py-3 text-center font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($termEnds as $index => $term)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 font-medium">{{ $term->name }}</td>
                        <td class="px-4 py-2">{{ $term->position ?? 'N/A' }}</td>
                        <td class="px-4 py-2">
                            {{ $term->start_date ? \Carbon\Carbon::parse($term->start_date)->format('M d, Y') : '—' }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $term->end_date ? \Carbon\Carbon::parse($term->end_date)->format('M d, Y') : '—' }}
                        </td>
                        <td class="px-4 py-2 text-center capitalize">
                            @if($term->reason === 'deleted')
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">Deleted</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">Term Ended</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            <form action="{{ route('admin.term_ends.destroy', $term->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Remove this record permanently?')" 
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-xs">
                                    Delete Record
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">No ended officials found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
