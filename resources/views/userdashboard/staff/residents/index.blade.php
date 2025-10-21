@extends('layouts.sidebar')

@section('content')
<div class="p-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold">Profiling & Residents</h1>

        <div class="space-x-2">
            {{-- New Resident Button --}}
            <a href="{{ route('staff.residents.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                New Resident
            </a>

            {{-- Import Form --}}
            <form action="{{ route('staff.residents.import') }}" method="POST" enctype="multipart/form-data" class="inline-block">
                @csrf
                <label for="importFile"
                       class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 cursor-pointer">
                    Import
                </label>
                <input id="importFile" type="file" name="file" accept=".xlsx,.csv"
                       class="hidden" onchange="this.form.submit()">
            </form>

            {{-- Export Button --}}
            <a href="{{ route('staff.residents.export') }}"
               class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 inline-block">
                Export
            </a>

            {{-- Reports Button --}}
            <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Reports
            </button>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <x-summary-card title="Total Residents" :value="$totalResidents" />
        <x-summary-card title="New this month" :value="$newThisMonth" />
        <x-summary-card title="Incomplete Profiles" :value="$incompleteProfiles" />
        <x-summary-card title="Households" :value="$households" />
    </div>

    {{-- Filters & Search --}}
    <div class="bg-white p-4 rounded-xl shadow mb-6">
        <form method="GET" action="{{ route('staff.residents.index') }}"
              class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            {{-- Search Bar --}}
            <div class="w-full md:w-1/3">
                <div class="relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by name, email, or keywords"
                           class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500 pr-10" />
                    <button type="submit" class="absolute right-2 top-2 text-gray-500 hover:text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Residents Table --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Full Name</th>
                    <th class="px-4 py-2 border">Phone Number</th>
                    <th class="px-4 py-2 border">Sex</th>
                    <th class="px-4 py-2 border">Civil Status</th>
                    <th class="px-4 py-2 border">sitio</th>
                    <th class="px-4 py-2 border">Verified</th>
                    <th class="px-4 py-2 border text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse ($residents as $resident)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 border">{{ $resident->id }}</td>
                        <td class="px-4 py-2 border">{{ $resident->name }}</td>
                        <td class="px-4 py-2 border">{{ $resident->phone_number }}</td>
                        <td class="px-4 py-2 border capitalize">{{ $resident->sex ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border capitalize">{{ $resident->civil_status ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border capitalize">{{ $resident->sitio ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border text-center">
                            {{ $resident->residency_verified ? 'Verified' : 'Unverified' }}
                        </td>
                        <td class="px-4 py-2 border text-center space-x-2">
                            <a href="{{ route('staff.residents.show', $resident->id) }}"
                               class="text-indigo-600 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-gray-500 py-4">
                            No residents found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $residents->links() }}
    </div>
</div>
@endsection

@push('scripts')
@endpush
