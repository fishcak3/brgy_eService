<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Community Information</h3>
        <button onclick="openModal('edit-community')" class="text-blue-600 hover:underline text-sm">
            <i class="fas fa-pen"></i> Edit
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <p><strong>Senior Citizen:</strong> {{ auth()->user()->senior_citizen ? 'Yes' : 'No' }}</p>
        <p><strong>Registered Voter:</strong> {{ auth()->user()->voter ? 'Yes' : 'No' }}</p>
    </div>
</div>
