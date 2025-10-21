<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Sectoral Information</h3>
        <button onclick="openModal('edit-sectoral')" class="text-blue-600 hover:underline text-sm">
            <i class="fas fa-pen"></i> Edit
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <p><strong>Solo Parent:</strong> {{ auth()->user()->solo_parent ? 'Yes' : 'No' }}</p>
        <p><strong>OFW:</strong> {{ auth()->user()->ofw ? 'Yes' : 'No' }}</p>
        <p><strong>PWD:</strong> {{ auth()->user()->pwd ? 'Yes' : 'No' }}</p>
        <p><strong>Out of School Children:</strong> {{ auth()->user()->out_of_school_children ? 'Yes' : 'No' }}</p>
        <p><strong>OSA:</strong> {{ auth()->user()->osa ? 'Yes' : 'No' }}</p>
        <p><strong>Unemployed:</strong> {{ auth()->user()->unemployed ? 'Yes' : 'No' }}</p>
        <p><strong>Laborforce:</strong> {{ auth()->user()->laborforce ? 'Yes' : 'No' }}</p>
        <p><strong>ISY/ISC:</strong> {{ auth()->user()->isy_isc ? 'Yes' : 'No' }}</p>
    </div>
</div>
