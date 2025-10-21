@extends('layouts.sidebar')

@section('title', 'Admin Dashboard')

@section('content')
<div class="p-6 space-y-8">

    <!-- SUMMARY CARDS jhRBb6qYi_ssg2S -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white shadow-md rounded-2xl p-5 border border-gray-100">
            <h3 class="text-sm text-gray-500">Total Residents</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $totalResidents ?? 0 }}</p>
        </div>

        <div class="bg-white shadow-md rounded-2xl p-5 border border-gray-100">
            <h3 class="text-sm text-gray-500">Document Requests</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ $pendingRequests ?? 0 }}</p>
            <div class="flex justify-between text-xs text-gray-500 mt-2">
                <span>Open: {{ $open ?? 0 }}</span>
                <span>Assigned: {{ $Assi ?? 0 }}</span>
                <span>Rejected: {{ $rejected ?? 0 }}</span>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-2xl p-5 border border-gray-100">
            <h3 class="text-sm text-gray-500">Complaints</h3>
            <p class="text-3xl font-bold text-red-600">{{ $openComplaints ?? 0 }}</p>
            <div class="flex justify-between text-xs text-gray-500 mt-2">
                <span>Open: {{ $openComplaints ?? 0 }}</span>
                <span>Resolved: {{ $resolvedComplaints ?? 0 }}</span>
                <span>Escalated: {{ $escalatedComplaints ?? 0 }}</span>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-2xl p-5 border border-gray-100">
            <h3 class="text-sm text-gray-500">Barangay Officials</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ $activeOfficials ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-2">Vacant positions: {{ $vacantPositions ?? 0 }}</p>
        </div>
    </div>

    <!-- INTERACTIVE CHARTS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl p-6 shadow-md">
            <h3 class="font-semibold text-gray-700 mb-3">Population Demographics</h3>
            <canvas id="populationChart" class="h-64"></canvas>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-md">
            <h3 class="font-semibold text-gray-700 mb-3">Request Trends (12 Months)</h3>
            <canvas id="requestTrendsChart" class="h-64"></canvas>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-md">
            <h3 class="font-semibold text-gray-700 mb-3">Complaint Resolution Analytics</h3>
            <canvas id="complaintChart" class="h-64"></canvas>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-md">
            <h3 class="font-semibold text-gray-700 mb-3">Service Performance Metrics</h3>
            <canvas id="performanceChart" class="h-64"></canvas>
        </div>
    </div>

    <!-- RECENT ACTIVITY -->
    <div class="bg-white rounded-2xl p-6 shadow-md">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-semibold text-gray-700">Recent Activity</h3>
            <button class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700">Refresh</button>
        </div>
        <ul class="divide-y divide-gray-100">
            @forelse ($recentActivities ?? [] as $activity)
                <li class="py-2 flex justify-between">
                    <span class="text-gray-700">{{ $activity->description }}</span>
                    <span class="text-gray-400 text-xs">{{ $activity->created_at->diffForHumans() }}</span>
                </li>
            @empty
                <li class="text-gray-400 text-center py-4">No recent activity</li>
            @endforelse
        </ul>
    </div>

    <!-- SYSTEM HEALTH -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl p-6 shadow-md">
            <h3 class="font-semibold text-gray-700 mb-3">System Health Indicators</h3>
            <ul class="text-sm space-y-2">
                <li><strong>Database:</strong> {{ $systemHealth['database'] ?? 'OK' }}</li>
                <li><strong>Backups:</strong> {{ $systemHealth['backup'] ?? 'Recent' }}</li>
                <li><strong>Notifications:</strong> {{ $systemHealth['notifications'] ?? 'Operational' }}</li>
                <li><strong>Uptime:</strong> {{ $systemHealth['uptime'] ?? '99.9%' }}</li>
            </ul>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-md">
            <h3 class="font-semibold text-gray-700 mb-3">Alerts</h3>
            @if(!empty($alerts))
                <ul class="list-disc list-inside text-red-600 text-sm">
                    @foreach($alerts as $alert)
                        <li>{{ $alert }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 text-sm">No critical alerts at this time.</p>
            @endif
        </div>
    </div>

</div>
@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Population Chart
    new Chart(document.getElementById('populationChart'), {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female', 'Seniors', 'PWDs', '4Ps'],
            datasets: [{
                data: [{{ $demographics['male'] ?? 0 }}, {{ $demographics['female'] ?? 0 }}, {{ $demographics['seniors'] ?? 0 }}, {{ $demographics['pwds'] ?? 0 }}, {{ $demographics['4ps'] ?? 0 }}],
                backgroundColor: ['#3B82F6', '#F472B6', '#FBBF24', '#34D399', '#A78BFA']
            }]
        },
        options: { responsive: true }
    });

    // Request Trends Chart
    new Chart(document.getElementById('requestTrendsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($months ?? []) !!},
            datasets: [{
                label: 'Requests',
                data: {!! json_encode($requestTrends ?? []) !!},
                borderColor: '#3B82F6',
                tension: 0.4,
                fill: false
            }]
        },
        options: { responsive: true }
    });

    // Complaint Chart
    new Chart(document.getElementById('complaintChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($complaintCategories ?? []) !!},
            datasets: [{
                label: 'Avg Resolution (days)',
                data: {!! json_encode($complaintResolutionTimes ?? []) !!},
                backgroundColor: '#EF4444'
            }]
        },
        options: { responsive: true }
    });

    // Service Performance Chart
    new Chart(document.getElementById('performanceChart'), {
        type: 'bar',
        data: {
            labels: ['SLA Compliance', 'Response Time', 'User Satisfaction'],
            datasets: [{
                data: [{{ $performance['sla'] ?? 90 }}, {{ $performance['response'] ?? 80 }}, {{ $performance['satisfaction'] ?? 95 }}],
                backgroundColor: ['#10B981', '#3B82F6', '#F59E0B']
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, max: 100 } }
        }
    });
});
</script>
@endpush

