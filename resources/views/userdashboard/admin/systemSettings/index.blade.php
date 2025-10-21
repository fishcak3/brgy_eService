@extends('layouts.sidebar')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">System Settings</h1>

    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-3">{{ session('error') }}</div>
    @endif

    <div class="bg-white shadow rounded p-6">
        <h2 class="text-lg font-semibold mb-4">Backup Your Data</h2>
        <p class="text-gray-600 mb-4">
            Click the button below to back up your entire database. A `.sql` file will be generated for download.
        </p>

        <form method="POST" action="{{ route('admin.system.backup') }}">
            @csrf
            <button type="submit"
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded shadow">
                <i class="fa fa-database mr-1"></i> Backup Now
            </button>
        </form>
    </div>
</div>
@endsection
