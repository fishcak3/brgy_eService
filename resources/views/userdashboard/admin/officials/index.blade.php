@extends('layouts.sidebar')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-700">Manage Barangay Officials</h1>
        <a href="{{ route('admin.officials.create') }}" 
           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            + Assign Official
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Full Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Position</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Assigned Since</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($officials as $official)
                    <tr>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3 text-sm font-medium text-gray-800">
                            {{ $official->resident ? 
                                $official->resident->lname . ', ' . $official->resident->fname . ' ' . $official->resident->mname : 
                                '—' }}
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-700">
                            @if($official->position)
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                                    {{ $official->position->title }}
                                </span>
                            @else
                                <span class="text-gray-400 text-sm italic">Unassigned</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-700">
                            {{ $official->resident->phone_number ?? '—' }}
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-700">
                            {{ $official->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-3 text-sm">
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Active</span>
                        </td>
                        <td class="px-6 py-3 text-sm text-right">
                            <a href="{{ route('admin.officials.show', $official->id) }}" 
                               class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>

                            <form action="{{ route('admin.officials.destroy', $official->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to remove this official?')"
                                        class="text-red-600 hover:text-red-800">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No officials assigned yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($officials, 'links'))
        <div class="mt-4">
            {{ $officials->links() }}
        </div>
    @endif
</div>
@endsection
