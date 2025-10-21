@extends('layouts.sidebar')

@section('content')
<div class="p-6">
    <div class="flex justify-between mb-6">
        <h1 class="text-xl font-bold">User Management</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add User</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-2 border">Name</th>
                <th class="p-2 border">Email</th>
                <th class="p-2 border">Role</th>
                <th class="p-2 border">Position</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="p-2 border">{{ $user->resident->name }}</td>
                <td class="p-2 border">{{ $user->email }}</td>
                <td class="p-2 border capitalize">{{ $user->role }}</td>
                <td class="p-2 border">{{ $user->positions->title ?? '-' }}</td>
                <td class="p-2 border">
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 ml-2" onclick="return confirm('Delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
