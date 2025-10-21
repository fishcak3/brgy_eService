<div id="edit-adress" class="modal fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
        <h2 class="text-lg font-bold mb-4">Edit Address Information</h2>
        <form method="POST" action="{{ route('profile.quickUpdate') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Region</label>
                    <input type="text" name="region" value="{{ auth()->user()->region }}" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Province</label>
                    <input type="text" name="province" value="{{ auth()->user()->province }}" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Municipality</label>
                    <input type="text" name="municipality" value="{{ auth()->user()->municipality }}" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Barangay</label>
                    <input type="text" name="barangay" value="{{ auth()->user()->barangay }}" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Sitio</label>
                    <input type="text" name="sitio" value="{{ auth()->user()->sitio }}" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Purok</label>
                    <input type="text" name="purok" value="{{ auth()->user()->purok }}" class="w-full border rounded px-3 py-2">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium">Household Number</label>
                    <input type="text" name="household_no" value="{{ auth()->user()->household_no }}" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <button type="button" onclick="closeModal('edit-adress')" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>
