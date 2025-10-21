@extends('layouts.sidebar')

@section('styles')
    {{-- Chart.js (quick) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Top row: KPIs --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Assigned to me</p>
                <p class="text-2xl font-semibold text-gray-800">{{ number_format($kpi['assigned'] ?? 0) }}</p>
                <p class="text-xs text-gray-500 mt-1">Active / Pending</p>
            </div>
            <div class="text-right">
                <a href="{{ route('staff.requests.index') }}" class="text-sm text-green-600 hover:underline">Open queue</a>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Due today</p>
                <p class="text-2xl font-semibold text-orange-600">{{ number_format($kpi['due_today'] ?? 0) }}</p>
                <p class="text-xs text-gray-500 mt-1">SLA expiring today</p>
            </div>
            <div class="text-right">
                <button class="text-sm text-orange-600">View</button>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Overdue</p>
                <p class="text-2xl font-semibold text-red-600">{{ number_format($kpi['overdue'] ?? 0) }}</p>
                <p class="text-xs text-gray-500 mt-1">Past SLA</p>
            </div>
            <div class="text-right">
                <button class="text-sm text-red-600">Resolve</button>
            </div>
        </div>

    </div>

    {{-- Main grid: left/middle/right --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- Left column (large): Requests insights + My queue --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Row: Charts --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-sm font-semibold text-gray-700">Requests by Type</h3>
                        <div class="text-xs text-gray-500">
                            <label class="mr-2">Range</label>
                            <select id="chartRange" class="border rounded px-2 py-1 text-xs">
                                <option value="7">Last 7 days</option>
                                <option value="30" selected>Last 30 days</option>
                                <option value="90">Last 90 days</option>
                            </select>
                        </div>
                    </div>
                    <canvas id="requestsByTypeChart" height="220"></canvas>
                </div>

                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Source Breakdown</h3>
                    <canvas id="sourceBreakdownChart" height="220"></canvas>
                    <div class="mt-3 text-xs text-gray-500">
                        <span class="inline-flex items-center mr-3"><span class="w-2 h-2 bg-blue-500 rounded-full mr-1"></span> Online</span>
                        <span class="inline-flex items-center mr-3"><span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span> Walk-in</span>
                        <span class="inline-flex items-center"><span class="w-2 h-2 bg-yellow-500 rounded-full mr-1"></span> Mobile</span>
                    </div>
                </div>
            </div>

            {{-- My Queue --}}
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">My Queue</h3>
                        <p class="text-sm text-gray-500">Requests assigned to you (click row for details)</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="" class="px-3 py-2 bg-green-600 text-white rounded text-sm">Quick-create (walk-in)</a>

                    </div>
                </div>

                {{-- Filters --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
                    <input type="text" id="globalSearch" placeholder="Search reference / resident / purok / OR #" class="border rounded px-3 py-2 text-sm">
                    <select id="filterStatus" class="border rounded px-3 py-2 text-sm">
                        <option value="">All Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <select id="filterPriority" class="border rounded px-3 py-2 text-sm">
                        <option value="">All Priority</option>
                        <option value="urgent">Urgent</option>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                    <div class="flex items-center">
                        <label class="text-xs text-gray-500 mr-2">Overdue only</label>
                        <input type="checkbox" id="overdueToggle" class="h-4 w-4">
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">#</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Reference</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Type</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Resident (Purok)</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Status</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">SLA</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Requested</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Payment</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Assigned</th>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="queueTableBody" class="bg-white divide-y divide-gray-200">
                            @foreach($myQueue as $r)
                            <tr class="hover:bg-gray-50 cursor-pointer" data-id="{{ $r->id }}" onclick="openRequestDetail({{ $r->id }})">
                                <td class="px-3 py-2 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 text-sm text-blue-600 font-medium">{{ $r->reference_no }}</td>
                                <td class="px-3 py-2 text-sm text-gray-700">{{ $r->requestType->name ?? 'N/A' }}</td>
                                <td class="px-3 py-2 text-sm text-gray-700">{{ $r->resident->name ?? 'N/A' }} <span class="text-xs text-gray-400">({{ $r->resident->purok ?? '—' }})</span></td>
                                <td class="px-3 py-2 text-sm">
                                    <span class="px-2 py-1 rounded text-xs {{ $r->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">{{ ucfirst($r->status) }}</span>
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-700">
                                    @if($r->needed_date && $r->needed_date < now())
                                        <span class="text-xs text-red-600 font-semibold">Overdue</span>
                                    @else
                                        {{ optional($r->needed_date)->format('M d') ?? '-' }}
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-700">{{ optional($r->requested_date)->format('M d') }}</td>
                                <td class="px-3 py-2 text-sm text-gray-700">{{ $r->fee ? '₱'.number_format($r->fee,2) : '—' }} <span class="text-xs text-gray-400">({{ $r->payment_status ?? 'Unpaid' }})</span></td>
                                <td class="px-3 py-2 text-sm text-gray-700">{{ $r->staff->name ?? 'Unassigned' }}</td>
                                <td class="px-3 py-2 text-right text-sm">
                                    <button onclick="event.stopPropagation();" class="text-sm text-blue-600 hover:underline" onclick="openRequestDetail({{ $r->id }})">Details</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $myQueue->links() ?? '' }}
                </div>
            </div>

            {{-- Approvals --}}
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Pending Approvals</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @foreach($approvals as $a)
                        <div class="p-3 border rounded">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-600">{{ $a->title }}</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $a->count }}</p>
                                </div>
                                <div class="text-right">
                                    <a href="{{ $a->url }}" class="text-indigo-600 text-sm">Open</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Right sidebar --}}
        <aside class="lg:col-span-4 space-y-6">

            {{-- Facility calendar --}}
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Facility Bookings (next 5)</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    @forelse($nextBookings as $b)
                    <li>
                        <div class="flex justify-between">
                            <div>
                                <div class="font-medium">{{ $b->facility_name }}</div>
                                <div class="text-xs text-gray-500">{{ $b->start_time->format('M d, H:i') }} — {{ $b->end_time->format('H:i') }}</div>
                                <div class="text-xs text-gray-500">By: {{ $b->reserved_by }}</div>
                            </div>
                            <div class="text-right">
                                @if(!$b->paid)
                                    <span class="text-xs text-red-600">Unpaid</span>
                                @endif
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="text-xs text-gray-500">No upcoming bookings.</li>
                    @endforelse
                </ul>
                <div class="mt-3 text-sm"><a href="" class="text-indigo-600">Open calendar</a></div>
            </div>

        </aside>

    </div>

    {{-- Drawer --}}
    <div id="requestDetailDrawer" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black opacity-40" onclick="closeRequestDetail()"></div>
        <div class="absolute right-0 top-0 bottom-0 w-full md:w-2/3 lg:w-1/2 bg-white shadow-xl overflow-y-auto">
            <div class="p-4 border-b flex justify-between items-center">
                <h2 id="drawerTitle" class="text-lg font-semibold">Request details</h2>
                <button class="text-gray-600" onclick="closeRequestDetail()">Close</button>
            </div>
            <div id="drawerContent" class="p-4">
                <p class="text-sm text-gray-500">Loading...</p>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    function openRequestDetail(id){
        document.getElementById('requestDetailDrawer').classList.remove('hidden');
        const content = document.getElementById('drawerContent');
        content.innerHTML = '<p class="text-sm text-gray-500">Loading…</p>';
        fetch(`/staff/requests/${id}`)
            .then(res => res.text())
            .then(html => content.innerHTML = html)
            .catch(err => content.innerHTML = '<p class="text-sm text-red-600">Failed to load</p>');
    }
    function closeRequestDetail(){
        document.getElementById('requestDetailDrawer').classList.add('hidden');
    }

    const requestsByTypeData = @json($charts['by_type'] ?? []);
    const sourceBreakdown = @json($charts['by_source'] ?? []);

    const ctx = document.getElementById('requestsByTypeChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: requestsByTypeData.map(r => r.label),
                datasets: [{
                    label: 'Requests',
                    data: requestsByTypeData.map(r => r.count),
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }

    const ctx2 = document.getElementById('sourceBreakdownChart');
    if (ctx2) {
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: sourceBreakdown.map(s => s.label),
                datasets: [{ data: sourceBreakdown.map(s => s.count) }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }
</script>
@endsection
