@extends('layouts.sidebar')

@section('content')
<div class="p-6 max-w-3xl mx-auto bg-white rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-green-700 mb-4">Assign Barangay Official</h2>

    <form action="{{ route('admin.officials.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium">Resident</label>
            <select name="resident_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Select Resident --</option>
                @foreach ($residents as $resident)
                    <option value="{{ $resident->id }}">{{ $resident->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Position</label>
            <select name="position_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Select Position --</option>
                @foreach ($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->title }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Start Date</label>
            <input type="date" name="date_start" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block font-medium">End Date</label>
            <input type="date" name="date_end" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-medium">Status</label>
            <select name="is_active" class="w-full border rounded px-3 py-2">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Save
            </button>
        </div>
    </form>
</div>
@endsection
