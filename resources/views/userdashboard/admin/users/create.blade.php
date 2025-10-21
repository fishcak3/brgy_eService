@extends('layouts.sidebar')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Create User</h1>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        {{-- 🔹 Select Resident (AJAX Searchable) --}}
        <div class="mt-2">
            <label class="block font-semibold mb-1">Select Resident (optional)</label>
            <select id="resident_id" name="resident_id" class="border p-2 w-full"></select>
            <p class="text-sm text-gray-500 mt-1">Search for a resident to auto-fill details.</p>
        </div>

        {{-- 🔹 Basic Info --}}
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block font-semibold mb-1">First Name</label>
                <input type="text" id="fname" name="fname" class="border p-2 w-full" required>
            </div>
            <div>
                <label class="block font-semibold mb-1">Middle Name</label>
                <input type="text" id="mname" name="mname" class="border p-2 w-full">
            </div>
            <div>
                <label class="block font-semibold mb-1">Last Name</label>
                <input type="text" id="lname" name="lname" class="border p-2 w-full" required>
            </div>
            <div>
                <label class="block font-semibold mb-1">Suffix</label>
                <input type="text" id="suffix" name="suffix" class="border p-2 w-full">
            </div>
        </div>

        {{-- 🔹 Personal Info --}}
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block font-semibold mb-1">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" class="border p-2 w-full">
            </div>
            <div>
                <label class="block font-semibold mb-1">Birthdate</label>
                <input type="date" id="birthdate" name="birthdate" class="border p-2 w-full">
            </div>
            <div>
                <label class="block font-semibold mb-1">Sex</label>
                <select id="sex" name="sex" class="border p-2 w-full">
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-1">Civil Status</label>
                <select id="civil_status" name="civil_status" class="border p-2 w-full">
                    <option value="">Select</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="widowed">Widowed</option>
                </select>
            </div>
        </div>

        {{-- 🔹 Address Info --}}
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block font-semibold mb-1">Region</label>
                <input type="text" id="region" name="region" class="border p-2 w-full">
            </div>
            <div>
                <label class="block font-semibold mb-1">Province</label>
                <input type="text" id="province" name="province" class="border p-2 w-full">
            </div>
            <div>
                <label class="block font-semibold mb-1">Municipality</label>
                <input type="text" id="municipality" name="municipality" class="border p-2 w-full">
            </div>
            <div>
                <label class="block font-semibold mb-1">Barangay</label>
                <input type="text" id="barangay" name="barangay" class="border p-2 w-full">
            </div>
            <div>
                <label class="block font-semibold mb-1">Street</label>
                <input type="text" id="street" name="street" class="border p-2 w-full">
            </div>
            <div>
                <label class="block font-semibold mb-1">Zone</label>
                <input type="text" id="zone" name="zone" class="border p-2 w-full">
            </div>
        </div>

        {{-- 🔹 Household --}}
        <div class="mt-4">
            <label class="block font-semibold mb-1">Household ID</label>
            <input type="text" id="household_id" name="household_id" class="border p-2 w-full">
        </div>

        {{-- 🔹 User Credentials --}}
        <div class="mt-4">
            <label class="block font-semibold mb-1">Email</label>
            <input type="email" id="email" name="email" class="border p-2 w-full" required>
        </div>

        <div class="mt-4">
            <label class="block font-semibold mb-1">Role</label>
            <select name="role" class="border p-2 w-full" required>
                <option value="resident">Resident</option>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Password</label>
                <input type="password" name="password" class="border p-2 w-full" required>
            </div>
            <div>
                <label class="block font-semibold mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" class="border p-2 w-full" required>
            </div>
        </div>

        <div class="mt-6">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Create User
            </button>
        </div>
    </form>
</div>

{{-- 🔹 Include Select2 Dependencies --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
    // Initialize Select2 with AJAX search
    $('#resident_id').select2({
        placeholder: 'Search Resident...',
        allowClear: true,
        ajax: {
            url: '{{ route("admin.residents.search") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { term: params.term };
            },
            processResults: function (data) {
                return { results: data };
            },
            cache: true
        }
    });

    // Autofill resident data when selected
    $('#resident_id').on('select2:select', function (e) {
        var residentId = e.params.data.id;
        $.ajax({
            url: `/admin/residents/${residentId}/details`,
            type: 'GET',
            success: function (data) {
                const fields = ['fname', 'mname', 'lname', 'suffix', 'phone_number', 'birthdate',
                                'sex', 'civil_status', 'region', 'province', 'municipality',
                                'barangay', 'street', 'zone', 'household_id'];
                fields.forEach(field => {
                    $('#' + field).val(data[field] ?? '');
                });
            }
        });
    });

    // Clear fields if deselected
    $('#resident_id').on('select2:clear', function () {
        const fields = ['fname', 'mname', 'lname', 'suffix', 'phone_number', 'birthdate',
                        'sex', 'civil_status', 'region', 'province', 'municipality',
                        'barangay', 'street', 'zone', 'household_id'];
        fields.forEach(field => $('#' + field).val(''));
    });
});
</script>
@endsection
