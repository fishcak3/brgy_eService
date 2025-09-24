@extends('layouts.app') {{-- adjust if you use a different layout --}}

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Welcome Header --}}
    <div class="mb-8">
        <h1 class="text-3xl text-gray-900 mb-2">Staff Dashboard</h1>
        <p class="text-gray-600">Welcome, {{ Auth::user()->name }}</p>
    </div>

    {{-- Quick Stats (empty placeholders) --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-6">Pending Requests</div>
        <div class="bg-white shadow rounded-lg p-6">Processing</div>
        <div class="bg-white shadow rounded-lg p-6">Open Complaints</div>
        <div class="bg-white shadow rounded-lg p-6">Completed Today</div>
        <div class="bg-white shadow rounded-lg p-6">Total Residents</div>
    </div>

    {{-- Tabs (empty layout) --}}
    <div x-data="{ tab: 'requests' }">
        <div class="grid grid-cols-5 border-b mb-6">
            <button @click="tab='requests'" :class="tab==='requests' ? 'border-b-2 border-blue-600 text-blue-600' : ''" class="py-2">Document Requests</button>
            <button @click="tab='complaints'" :class="tab==='complaints' ? 'border-b-2 border-blue-600 text-blue-600' : ''" class="py-2">Manage Complaints</button>
            <button @click="tab='residents'" :class="tab==='residents' ? 'border-b-2 border-blue-600 text-blue-600' : ''" class="py-2">Resident Records</button>
            <button @click="tab='announcements'" :class="tab==='announcements' ? 'border-b-2 border-blue-600 text-blue-600' : ''" class="py-2">Announcements</button>
            <button @click="tab='messages'" :class="tab==='messages' ? 'border-b-2 border-blue-600 text-blue-600' : ''" class="py-2">Staff Messages</button>
        </div>

        {{-- Empty tab content placeholders --}}
        <div x-show="tab==='requests'" class="bg-white shadow p-6 rounded-lg">
            <h2 class="font-semibold mb-3">Document Requests</h2>
            <div class="text-gray-500">No data yet</div>
        </div>

        <div x-show="tab==='complaints'" class="bg-white shadow p-6 rounded-lg">
            <h2 class="font-semibold mb-3">Complaints</h2>
            <div class="text-gray-500">No data yet</div>
        </div>

        <div x-show="tab==='residents'" class="bg-white shadow p-6 rounded-lg">
            <h2 class="font-semibold mb-3">Residents</h2>
            <div class="text-gray-500">No data yet</div>
        </div>

        <div x-show="tab==='announcements'" class="bg-white shadow p-6 rounded-lg">
            <h2 class="font-semibold mb-3">Announcements</h2>
            <div class="text-gray-500">No data yet</div>
        </div>

        <div x-show="tab==='messages'" class="bg-white shadow p-6 rounded-lg">
            <h2 class="font-semibold mb-3">Messages</h2>
            <div class="text-gray-500">No data yet</div>
        </div>
    </div>

</div>
@endsection
