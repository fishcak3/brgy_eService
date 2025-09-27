@extends('layouts.app') {{-- adjust if you use a different layout --}}

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Welcome Header --}}
    <div class="mb-8">
        <h1 class="text-3xl text-gray-900 mb-2">Staff Dashboard</h1>
        <p class="text-gray-600">Welcome, {{ Auth::user()->name }}</p>
    </div>
    
</div>
@endsection
