
         <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-red-600 mb-2">Account Management</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Advanced account settings and actions
                </p>
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
                        Request Account Deletion
                    </button>
                </form>
                <p class="mt-2 text-xs text-gray-500">
                    For other account changes or issues, please contact the barangay office directly.
                </p>
            </div>