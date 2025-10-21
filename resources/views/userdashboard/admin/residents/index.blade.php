@extends('layouts.sidebar')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-700">Residents List</h1>

        <div class="flex items-center space-x-3">
            {{-- Import Residents Button --}}
            <form action="{{ route('admin.residents.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="importFile" 
                       class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 cursor-pointer transition">
                    Import
                </label>
                <input id="importFile" 
                       type="file" 
                       name="file" 
                       accept=".xlsx,.csv" 
                       class="hidden" 
                       onchange="this.form.submit()">
            </form>

            {{-- Add Resident Button --}}
            <a href="{{ route('admin.residents.create') }}" 
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                Add Resident
            </a>
        </div>
    </div>

    {{-- Flash Messages --}}
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

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Full Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Birthdate</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Address</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($residents as $resident)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $resident->name }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $resident->birthdate?->format('M d, Y') ?? '—' }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $resident->phone_number ?? '—' }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">
                            {{ $resident->barangay ?? '—' }}, {{ $resident->municipality ?? '' }}
                        </td>
                        <td class="px-6 py-3 text-sm text-right space-x-3">
                            <a href="{{ route('admin.residents.show', $resident->id) }}" 
                               class="text-blue-600 hover:text-blue-800">View</a>
                            <a href="{{ route('admin.residents.edit', $resident->id) }}" 
                               class="text-green-600 hover:text-green-800">Edit</a>
                            <form action="{{ route('admin.residents.destroy', $resident->id) }}" 
                                  method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this resident?')"
                                        class="text-red-600 hover:text-red-800">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No residents found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(method_exists($residents, 'links'))
        <div class="mt-4">
            {{ $residents->links() }}
        </div>
    @endif
</div>
@endsection
