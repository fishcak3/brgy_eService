<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>
        <button onclick="openModal('edit-personal')" class="text-blue-600 hover:underline text-sm">
            <i class="fas fa-pen"></i> Edit
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <p><strong>Full Name:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>Phone Number:</strong> {{ auth()->user()->phone_number ?? 'Not provided' }}</p>
        <p><strong>Birthdate:</strong> {{ auth()->user()->birthdate ?? 'Not provided' }}</p>
        <p><strong>Age:</strong> {{ auth()->user()->age ?? 'Not provided' }}</p>
        <p><strong>Sex:</strong> {{ auth()->user()->sex ?? 'Not provided' }}</p>
        <p><strong>Civil Status:</strong> {{ auth()->user()->civil_status ?? 'Not provided' }}</p>
        <p><strong>Mother's Maiden Name:</strong> {{ auth()->user()->mother_maiden_name ?? 'Not provided' }}</p>
    </div>
</div>
