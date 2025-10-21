@extends('layouts.sidebar')
@section('content')
<div class="container mt-4">
    <h2>Add New Position</h2>

    <form action="{{ route('admin.positions.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Position Title</label>
            <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="max_members" class="form-label">Maximum Number of Residents</label>
            <input type="number" name="max_members" id="max_members" class="form-control" min="1" value="{{ old('max_members', 1) }}">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
