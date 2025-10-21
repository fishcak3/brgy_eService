<div class="bg-white rounded-lg shadow p-6 text-center">
    {{-- Profile Photo --}}
    <div class="h-32 w-32 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center mx-auto">
        @if(Auth::user()->photo)
            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile Photo" class="h-full w-full object-cover">
        @else
            <span class="text-3xl font-bold text-gray-500">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </span>
        @endif
    </div>

    <h2 class="mt-4 text-xl font-semibold text-gray-900">{{ auth()->user()->name }}</h2>
    <span class="inline-block bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full mt-2 capitalize">
        {{ auth()->user()->role }}
    </span>

    <p class="mt-4 text-gray-600">
        <i class="fas fa-envelope"></i> {{ auth()->user()->email }}
    </p>
    <p class="text-sm text-gray-500">Joined {{ auth()->user()->created_at->format('F j, Y') }}</p>

    {{-- Quick Edit Buttons --}}
    <div class="mt-6 text-left space-y-2">
        <button onclick="openModal('edit-personal')" class="w-full text-left text-blue-600 hover:underline">
            <i class="fas fa-user-edit"></i> Edit Personal Info
        </button>
        <button onclick="openModal('edit-adress')" class="w-full text-left text-blue-600 hover:underline">
            <i class="fas fa-map-marker-alt"></i> Edit Address Info
        </button>
        <button onclick="openModal('edit-sectoral')" class="w-full text-left text-blue-600 hover:underline">
            <i class="fas fa-users"></i> Edit Sectoral Info
        </button>
        <button onclick="openModal('edit-community')" class="w-full text-left text-blue-600 hover:underline">
            <i class="fas fa-city"></i> Edit Community Info
        </button>
    </div>
</div>
