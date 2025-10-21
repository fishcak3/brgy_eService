@extends('layouts.sidebar')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold">Create Document Request</h1>
        <a href="{{ route('staff.requests.index') }}" class="text-sm text-indigo-600 hover:underline">← Back to Requests</a>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <form action="{{ route('staff.documents.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Resident Name</label>
                    <input type="text" name="resident_name" class="w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" class="w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Document Type</label>
                    <select name="document_type" class="w-full border rounded-lg p-2" required>
                        <option value="">-- Select Type --</option>
                        <option value="Barangay Clearance">Barangay Clearance</option>
                        <option value="Certificate of Residency">Certificate of Residency</option>
                        <option value="Certificate of Indigency">Certificate of Indigency</option>
                        <option value="Business Permit">Business Permit</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Purpose</label>
                    <input type="text" name="purpose" class="w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                    <select name="payment_status" class="w-full border rounded-lg p-2">
                        <option value="Pending">Pending</option>
                        <option value="Paid">Paid</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Requested</label>
                    <input type="date" name="request_date" value="{{ now()->toDateString() }}" class="w-full border rounded-lg p-2">
                </div>
            </div>

            <div class="mt-6 text-right">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
