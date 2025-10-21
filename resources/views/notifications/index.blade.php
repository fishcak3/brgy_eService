@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">My Notifications</h1>

    @if($notifications->count() > 0)
        <div class="bg-white shadow rounded-lg divide-y">
            @foreach($notifications as $notif)
                <div class="p-4 {{ $notif->read_at ? 'bg-white' : 'bg-gray-50' }}">
                    <p class="font-medium text-gray-800">{{ $notif->title }}</p>
                    <p class="text-gray-600">{{ $notif->message }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @else
        <p class="text-gray-600">No notifications found.</p>
    @endif
</div>
@endsection
