<div id="edit-community" class="modal fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
        <h2 class="text-lg font-bold mb-4">Edit Community Information</h2>
        <form method="POST" action="{{ route('profile.quickUpdate') }}">
            @csrf

            <div class="space-y-3">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="senior_citizen" value="1" {{ auth()->user()->senior_citizen ? 'checked' : '' }} class="rounded">
                    <span>Senior Citizen</span>
                </label>

                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="voter" value="1" {{ auth()->user()->voter ? 'checked' : '' }} class="rounded">
                    <span>Registered Voter</span>
                </label>
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <button type="button" onclick="closeModal('edit-community')" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>
