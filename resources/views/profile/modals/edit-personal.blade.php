<div id="edit-personal" 
     class="modal fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50"
     aria-hidden="true" role="dialog" aria-labelledby="editPersonalTitle">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">

        {{-- Modal Header --}}
        <div class="flex justify-between items-center mb-4">
            <h2 id="editPersonalTitle" class="text-lg font-bold text-gray-800">
                Edit Personal Information
            </h2>
            <button type="button" onclick="closeModal('edit-personal')" 
                    class="text-gray-500 hover:text-gray-700 text-xl font-bold">
                &times;
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('profile.quickUpdate') }}" enctype="multipart/form-data">
            @csrf

            {{-- Name & Phone --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}"
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('phone_number')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Birthdate & Sex --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Birthdate</label>
                    <input type="date" name="birthdate" value="{{ old('birthdate', auth()->user()->birthdate) }}"
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sex</label>
                    <select name="sex" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Select...</option>
                        <option value="Male" {{ auth()->user()->sex == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ auth()->user()->sex == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
            </div>

            {{-- Civil Status & Mother's Maiden Name --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Civil Status</label>
                    <select name="civil_status" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Select...</option>
                        <option value="Single" {{ auth()->user()->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ auth()->user()->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Widowed" {{ auth()->user()->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                        <option value="Separated" {{ auth()->user()->civil_status == 'Separated' ? 'selected' : '' }}>Separated</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mother’s Maiden Name</label>
                    <input type="text" name="mother_maiden_name" 
                           value="{{ old('mother_maiden_name', auth()->user()->mother_maiden_name) }}"
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            {{-- Buttons --}}
            <div class="mt-6 flex justify-end gap-2">
                <button type="button" 
                        onclick="closeModal('edit-personal')" 
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

