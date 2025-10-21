<div id="edit-sectoral" class="modal fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
        <h2 class="text-lg font-bold mb-4">Edit Sectoral Information</h2>
        <form method="POST" action="{{ route('profile.quickUpdate') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                @php
                    $fields = [
                        'solo_parent' => 'Solo Parent',
                        'ofw' => 'OFW',
                        'pwd' => 'PWD',
                        'out_of_school_children' => 'Out of School Children',
                        'osa' => 'OSA',
                        'unemployed' => 'Unemployed',
                        'laborforce' => 'Laborforce',
                        'isy_isc' => 'ISY/ISC',
                    ];
                @endphp

                @foreach($fields as $field => $label)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="{{ $field }}" value="1" 
                               {{ auth()->user()->$field ? 'checked' : '' }} class="rounded">
                        <span>{{ $label }}</span>
                    </label>
                @endforeach
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <button type="button" onclick="closeModal('edit-sectoral')" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>
