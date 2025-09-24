@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">New Document Request</h2>

    <form action="{{ route('document-requests.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium">Request Type</label>
            <input type="text" name="request_type" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Details</label>
            <textarea name="details" class="w-full border rounded p-2"></textarea>
        </div>

        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Submit</button>
    </form>
</div>
@endsection
