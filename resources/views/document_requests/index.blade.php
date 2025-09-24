@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">My Document Requests</h2>

    <a href="{{ route('document-requests.create') }}" 
       class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded">
        + New Request
    </a>

    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Type</th>
                <th class="border px-4 py-2">Details</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requests as $req)
                <tr>
                    <td class="border px-4 py-2">{{ $req->request_type }}</td>
                    <td class="border px-4 py-2">{{ $req->details }}</td>
                    <td class="border px-4 py-2">{{ $req->status }}</td>
                    <td class="border px-4 py-2">{{ $req->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4">No requests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
