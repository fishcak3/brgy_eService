@php
    $layout = in_array(auth()->user()->role, ['admin', 'staff']) 
        ? 'layouts.sidebar' 
        : 'layouts.app';
@endphp

@extends($layout)

@section('content')
<div class="max-w-6xl mx-auto pd=6">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">My Profile</h1>
    <p class="text-gray-600 mb-6">Manage your personal information and account settings</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- ✅ Left Column (Profile Card) --}}
        <div>
            @include('profile.components.profile-card')
        </div>

        {{-- ✅ Right Column (Profile Sections) --}}
        <div class="col-span-2 space-y-6">
            @include('profile.sections.personal')
            @include('profile.sections.address')
            @include('profile.sections.sectoral')
            @include('profile.sections.community')
            @include('profile.sections.acc-management')
        </div>
    </div>
</div>

{{-- Include Modals --}}
@include('profile.modals.edit-personal')
@include('profile.modals.edit-address')
@include('profile.modals.edit-sectoral')
@include('profile.modals.edit-community')

{{-- Modal Script --}}
<script>
/**
 * Opens a modal
 */
function openModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

/**
 * Closes a modal
 */
function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

function handleBackdropClick(event, id) {
    if (event.target.id === id) {
        closeModal(id);
    }
}

/**
 * Closes all modals when ESC is pressed
 */
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal').forEach(modal => modal.classList.add('hidden'));
        document.body.classList.remove('overflow-hidden');
    }
});
</script>
@endsection
