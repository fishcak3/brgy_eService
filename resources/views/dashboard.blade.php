@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <!-- Cards -->
    <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-sm text-gray-600">Active Complaints</h2>
        <p class="text-3xl font-bold text-red-600">2</p>
    </div>

    <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-sm text-gray-600">Pending Requests</h2>
        <p class="text-3xl font-bold text-yellow-500">3</p>
    </div>

    <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-sm text-gray-600">Completed</h2>
        <p class="text-3xl font-bold text-green-600">5</p>
    </div>

    <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-sm text-gray-600">Total Submissions</h2>
        <p class="text-3xl font-bold text-blue-600">7</p>
    </div>
</div>

<!-- Chart Section -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <h2 class="text-lg font-semibold mb-4">Requests Trend</h2>
    <canvas id="requestsChart"></canvas>
</div>

<!-- Recent Activity -->
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-lg font-semibold mb-4">Recent Activity</h2>
    <ul class="space-y-3">
        <li class="p-3 bg-green-100 rounded">
            <span class="font-bold">Barangay Clearance Approved</span> - 2 hours ago
        </li>
        <li class="p-3 bg-yellow-100 rounded">
            <span class="font-bold">Noise Complaint Application Submitted</span> - 1 day ago
        </li>
    </ul>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('requestsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
            datasets: [{
                label: 'Requests',
                data: [12, 19, 9, 17, 22, 13, 15],
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(249, 115, 22, 0.2)',
                tension: 0.4,
                fill: true
            }]
        }
    });
</script>
@endpush
