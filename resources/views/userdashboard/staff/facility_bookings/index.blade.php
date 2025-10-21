{{-- resources/views/facility_bookings/index.blade.php --}}
@extends('layouts.sidebar')

@section('styles')
    {{-- If you want a calendar lib later, you can add FullCalendar or similar --}}
    <style>
        /* small layout helpers */
        .chip { @apply inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium; }
        .chip-pending { @apply bg-yellow-100 text-yellow-800; }
        .chip-confirmed { @apply bg-green-100 text-green-800; }
        .chip-rejected { @apply bg-red-100 text-red-800; }
        .pointer { cursor: pointer; }
        /* drawer */
        .drawer-enter { transform: translateX(100%); }
    </style>
@endsection

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Facility Bookings</h1>
            <p class="text-sm text-gray-600">Review booking requests, check availability, and manage the schedule.</p>
        </div>

        <div class="flex items-center space-x-2">
            {{-- Quick exports & revenue --}}
            <button onclick="exportSchedule('pdf')" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">Export PDF</button>
            <button onclick="exportSchedule('csv')" class="px-3 py-2 bg-gray-200 text-gray-800 rounded-md text-sm hover:bg-gray-300">Export CSV</button>
            <a href="" class="px-3 py-2 bg-yellow-500 text-white rounded-md text-sm hover:bg-yellow-600">Revenue</a>
        </div>
    </div>

    {{-- Top Row: Quick filters --}}
    <div class="grid gap-4 md:grid-cols-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <label class="text-xs text-gray-500">Quick View</label>
            <div class="mt-2 flex gap-2">
                <button class="px-3 py-2 rounded-md bg-blue-50 text-blue-700 text-sm" onclick="filterQuick('pending')">Pending Approvals</button>
                <button class="px-3 py-2 rounded-md bg-red-50 text-red-700 text-sm" onclick="filterQuick('conflicts')">Scheduling Conflicts</button>
                <button class="px-3 py-2 rounded-md bg-green-50 text-green-700 text-sm" onclick="filterQuick('today')">Today's Requests</button>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <label class="text-xs text-gray-500">Facility</label>
            <select id="filterFacility" class="w-full mt-2 border rounded-md p-2 text-sm">
                <option value="">All facilities</option>
                @foreach($facilities as $f)
                    <option value="{{ $f->id }}">{{ $f->name }} — cap: {{ $f->capacity }}</option>
                @endforeach
            </select>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <label class="text-xs text-gray-500">Status</label>
            <select id="filterStatus" class="w-full mt-2 border rounded-md p-2 text-sm">
                <option value="">Any</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <label class="text-xs text-gray-500">Search</label>
            <div class="mt-2 flex gap-2">
                <input id="globalSearch" type="text" placeholder="Ref no, requester, phone, notes" class="flex-1 border rounded-md p-2 text-sm" />
                <button onclick="applyFilters()" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm">Apply</button>
            </div>
        </div>
    </div>

    {{-- Grid: Left list + Right detail/calendar --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- Left: Booking Requests Queue (table) --}}
        <div class="lg:col-span-7 space-y-6">

            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-600 uppercase">
                        <tr>
                            <th class="px-4 py-3">Request ID</th>
                            <th class="px-4 py-3">Facility</th>
                            <th class="px-4 py-3">Requester</th>
                            <th class="px-4 py-3">Event Date / Time</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Requested On</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($requests as $req)
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="openDetail({{ $req->id }})">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $req->reference_no ?? 'REQ-'.$req->id }}</td>
                            <td class="px-4 py-3">{{ $req->facility->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium">{{ $req->requester_name }}</div>
                                <div class="text-xs text-gray-500">{{ $req->requester_phone }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div>{{ optional($req->event_start)->format('M d, Y H:i') }}</div>
                                <div class="text-xs text-gray-500">{{ optional($req->event_end)->format('M d, Y H:i') }}</div>
                            </td>
                            <td class="px-4 py-3">
                                @if($req->status === 'pending')
                                    <span class="chip chip-pending">Pending</span>
                                @elseif($req->status === 'confirmed')
                                    <span class="chip chip-confirmed">Confirmed</span>
                                @else
                                    <span class="chip chip-rejected">Rejected</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $req->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-4 py-6 text-center text-gray-500" colspan="6">No booking requests found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Conflict resolution tile / list --}}
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-gray-800">Conflicts / Attention</h3>
                    <button class="text-xs text-indigo-600" onclick="showAllConflicts()">View all</button>
                </div>

                @if(count($conflicts ?? []) > 0)
                <ul class="space-y-2">
                    @foreach($conflicts as $c)
                        <li class="flex items-start justify-between p-3 border rounded">
                            <div>
                                <div class="text-sm font-medium">{{ $c->facility_name }} — {{ $c->reference_no }}</div>
                                <div class="text-xs text-gray-500">{{ $c->conflict_reason }}</div>
                                <div class="text-xs text-gray-500">Overlap: {{ optional($c->start)->format('M d H:i') }} — {{ optional($c->end)->format('M d H:i') }}</div>
                            </div>
                            <div class="flex flex-col items-end space-y-2">
                                <button class="px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded" onclick="proposeSlot({{ $c->id }})">Propose new slot</button>
                                <button class="px-3 py-1 text-sm bg-gray-100 rounded" onclick="openDetail({{ $c->id }})">Open</button>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @else
                <div class="text-xs text-gray-500">No conflicts detected.</div>
                @endif
            </div>

            {{-- Bulk actions / quick utilities --}}
            <div class="bg-white p-4 rounded-lg shadow flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div class="flex gap-2">
                    <button class="px-3 py-2 bg-green-600 text-white rounded text-sm" onclick="bulkApprove()">Approve Selected</button>
                    <button class="px-3 py-2 bg-red-500 text-white rounded text-sm" onclick="bulkReject()">Reject Selected</button>
                </div>
                <div class="text-xs text-gray-500">Tip: Select multiple requests to perform bulk operations.</div>
            </div>
        </div>

        {{-- Right: Detail panel + mini calendar + availability --}}
        <aside class="lg:col-span-5 space-y-6">

            {{-- Detail & Action Panel (drawer-like within page) --}}
            <div id="detailPanel" class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 id="detailTitle" class="text-lg font-semibold text-gray-800">Select a booking</h3>
                        <p id="detailRef" class="text-xs text-gray-500">Click a request to view details</p>
                    </div>
                    <div>
                        <span id="detailStatus" class="chip chip-pending">—</span>
                    </div>
                </div>

                <div id="detailBody" class="mt-4 text-sm text-gray-700">
                    {{-- populated via JS / ajax --}}
                    <p class="text-xs text-gray-500">Requester and event details will appear here.</p>
                </div>

                <div id="detailActions" class="mt-4 flex flex-wrap gap-2">
                    <button id="approveBtn" onclick="actionApprove()" class="px-3 py-2 bg-green-600 text-white rounded-md text-sm hidden">Approve</button>
                    <button id="rejectBtn" onclick="actionRejectPrompt()" class="px-3 py-2 bg-red-500 text-white rounded-md text-sm hidden">Reject</button>
                    <button id="infoBtn" onclick="requestMoreInfo()" class="px-3 py-2 bg-gray-200 text-gray-800 rounded-md text-sm hidden">Request More Info</button>
                    <button id="editBtn" onclick="openDateEditor()" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm hidden">Edit Dates</button>
                    <button id="printBtn" onclick="printBooking()" class="px-3 py-2 bg-gray-100 text-gray-800 rounded-md text-sm hidden">Print</button>
                </div>
            </div>

            {{-- Mini Calendar + Availability Checker --}}
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-gray-800">Mini Calendar & Availability</h3>
                    <button class="text-xs text-indigo-600" onclick="openFullCalendar()">Open calendar</button>
                </div>

                {{-- Simple placeholder calendar (replace with FullCalendar integration later) --}}
                <div id="miniCalendar" class="border rounded p-3 mb-3 text-center text-xs text-gray-500">
                    <!-- Placeholder: show mini calendar with busy slots highlighted -->
                    <div class="text-sm font-medium text-gray-700 mb-2">Oct 2025</div>
                    <div class="grid grid-cols-7 gap-1 text-xs">
                        {{-- generate simple day cells in the controller or via JS --}}
                        <div class="p-1">1</div>
                        <div class="p-1">2</div>
                        <div class="p-1">3</div>
                        {{-- ... --}}
                        <div class="p-1">31</div>
                    </div>
                </div>

                {{-- Availability checker --}}
                <div class="text-xs text-gray-700">
                    <label class="block mb-1 text-gray-500">Check availability</label>
                    <div class="grid grid-cols-1 gap-2">
                        <select id="availFacility" class="border rounded-md p-2 text-sm">
                            <option value="">Select facility</option>
                            @foreach($facilities as $f)
                                <option value="{{ $f->id }}">{{ $f->name }}</option>
                            @endforeach
                        </select>
                        <input id="availStart" type="datetime-local" class="border rounded-md p-2 text-sm" />
                        <input id="availEnd" type="datetime-local" class="border rounded-md p-2 text-sm" />
                        <div class="flex gap-2">
                            <button onclick="checkAvailability()" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm">Check</button>
                            <div id="availResult" class="text-sm self-center text-gray-600">—</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Today's & Upcoming tiles --}}
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-sm font-semibold text-gray-800 mb-3">Upcoming</h3>

                <div class="grid grid-cols-1 gap-3">
                    <div class="p-3 border rounded flex justify-between items-center">
                        <div>
                            <div class="text-sm font-medium">Today — Confirmed</div>
                            @forelse($todayBookings as $tb)
                                <div class="text-xs text-gray-600">{{ $tb->facility_name }} • {{ optional($tb->event_start)->format('H:i') }} — {{ optional($tb->event_end)->format('H:i') }} — {{ $tb->reference_no }}</div>
                            @empty
                                <div class="text-xs text-gray-500">No confirmed bookings today.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="p-3 border rounded">
                        <div class="text-sm font-medium">Tomorrow (top 3)</div>
                        @forelse($tomorrowTop as $t)
                            <div class="text-xs text-gray-600 mt-1">{{ $t->facility_name }} • {{ optional($t->event_start)->format('M d H:i') }} — {{ $t->reference_no }}</div>
                        @empty
                            <div class="text-xs text-gray-500">No bookings tomorrow.</div>
                        @endforelse
                    </div>

                    <div class="p-3 border rounded">
                        <div class="text-sm font-medium">Flagged / High priority</div>
                        @forelse($flagged as $f)
                            <div class="text-xs text-gray-600 mt-1">{{ $f->facility_name }} • {{ $f->reference_no }} • {{ $f->priority }}</div>
                        @empty
                            <div class="text-xs text-gray-500">None flagged.</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </aside>
    </div>
</div>

{{-- Rejection / More info prompt modal (simple) --}}
<div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-40 hidden z-50 items-center justify-center">
    <div class="bg-white rounded-lg p-4 w-11/12 md:w-1/3">
        <h3 class="text-lg font-semibold mb-2">Reject Booking</h3>
        <p class="text-sm text-gray-600 mb-3">Provide a reason for rejecting this booking.</p>
        <textarea id="rejectReason" class="w-full border rounded p-2 text-sm" rows="4"></textarea>
        <div class="mt-3 flex justify-end gap-2">
            <button class="px-3 py-2 bg-gray-200 rounded" onclick="closeModal()">Cancel</button>
            <button class="px-3 py-2 bg-red-600 text-white rounded" onclick="submitReject()">Reject</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // --- UX helpers (replace with AJAX / Livewire as needed) ---
    let currentRequestId = null;

    function openDetail(id) {
        currentRequestId = id;
        // ideally fetch details via AJAX. Here we'll simulate:
        document.getElementById('detailTitle').innerText = 'Loading...';
        document.getElementById('detailRef').innerText = '';
        document.getElementById('detailStatus').innerText = 'Loading';

        // Example: use fetch to load details endpoint
        fetch(`/facility-bookings/${id}`)
            .then(r => r.json())
            .then(data => {
                // update panel
                document.getElementById('detailTitle').innerText = data.title || ('Booking ' + data.reference_no);
                document.getElementById('detailRef').innerText = data.reference_no || '';
                document.getElementById('detailStatus').innerText = data.status || '';
                document.getElementById('detailBody').innerHTML = `
                    <div class="text-sm">
                        <div class="mb-2"><strong>Requester:</strong> ${data.requester_name} — ${data.requester_phone || '—'}</div>
                        <div class="mb-2"><strong>Organization:</strong> ${data.organization || '—'}</div>
                        <div class="mb-2"><strong>Event:</strong> ${data.event_description || '—'}</div>
                        <div class="mb-2"><strong>Facility:</strong> ${data.facility_name || '—'} (cap: ${data.capacity || '—'})</div>
                        <div class="mb-2"><strong>Slot:</strong> ${data.event_start} — ${data.event_end}</div>
                    </div>
                `;

                // Show action buttons depending on status/role
                showDetailActions(data.status);
            })
            .catch(() => {
                document.getElementById('detailTitle').innerText = 'Failed to load';
            });
    }

    function showDetailActions(status) {
        const show = (id, visible) => document.getElementById(id).classList.toggle('hidden', !visible);
        // simple rules: if pending -> show actions
        show('approveBtn', status === 'pending');
        show('rejectBtn', status === 'pending');
        show('infoBtn', status === 'pending');
        show('editBtn', status === 'pending' || status === 'confirmed');
        show('printBtn', status !== 'pending'); // allow print once there's a record
    }

    function actionApprove() {
        if (!currentRequestId) return alert('Select a booking first.');
        if (!confirm('Approve this booking?')) return;
        // POST /facility-bookings/{id}/approve
        fetch(`/facility-bookings/${currentRequestId}/approve`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' }})
            .then(()=> { alert('Approved'); location.reload(); })
            .catch(()=> alert('Failed'));
    }

    function actionRejectPrompt() {
        if (!currentRequestId) return alert('Select a booking first.');
        document.getElementById('modalOverlay').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('modalOverlay').classList.add('hidden');
    }
    function submitReject() {
        const reason = document.getElementById('rejectReason').value.trim();
        if (!reason) return alert('Please provide a reason.');
        // POST rejection
        fetch(`/facility-bookings/${currentRequestId}/reject`, {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({ reason })
        })
        .then(()=> { alert('Rejected'); closeModal(); location.reload(); })
        .catch(()=> alert('Failed to reject'));
    }

    function requestMoreInfo() {
        const note = prompt('Enter the information to request from the requester:');
        if (!note) return;
        fetch(`/facility-bookings/${currentRequestId}/request-info`, {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({ note })
        }).then(()=> alert('Requested more info')).catch(()=> alert('Failed'));
    }

    function openDateEditor() {
        // animate or open a date editor UI (left as stub)
        alert('Open date/time editor (implement modal or inline editor).');
    }

    function printBooking() {
        window.open(`/facility-bookings/${currentRequestId}/print`, '_blank');
    }

    function checkAvailability() {
        const facility = document.getElementById('availFacility').value;
        const start = document.getElementById('availStart').value;
        const end = document.getElementById('availEnd').value;
        if (!facility || !start || !end) {
            document.getElementById('availResult').innerText = 'Select facility and date/time';
            return;
        }
        document.getElementById('availResult').innerText = 'Checking...';
        fetch(`/facility-bookings/check?facility=${facility}&start=${encodeURIComponent(start)}&end=${encodeURIComponent(end)}`)
            .then(r => r.json())
            .then(res => {
                if (res.available) {
                    document.getElementById('availResult').innerHTML = '<span class="text-green-600">Available</span>';
                } else {
                    document.getElementById('availResult').innerHTML = '<span class="text-red-600">Conflict with existing booking</span>';
                }
            })
            .catch(()=> document.getElementById('availResult').innerText = 'Failed to check');
    }

    function filterQuick(mode) {
        // simple client-side action: set filters or call backend
        if (mode === 'pending') {
            document.getElementById('filterStatus').value = 'pending';
        } else if (mode === 'conflicts') {
            // you'd call the server for conflicts
            alert('Filtering to show conflicts — implement server-side filter.');
        } else if (mode === 'today') {
            alert('Filtering to show today — set date range to today and apply.');
        }
        applyFilters();
    }

    function applyFilters() {
        const facility = document.getElementById('filterFacility').value;
        const status = document.getElementById('filterStatus').value;
        const search = document.getElementById('globalSearch').value;
        // Reload page with query params (or use AJAX)
        const url = new URL(window.location.href);
        if (facility) url.searchParams.set('facility', facility); else url.searchParams.delete('facility');
        if (status) url.searchParams.set('status', status); else url.searchParams.delete('status');
        if (search) url.searchParams.set('q', search); else url.searchParams.delete('q');
        window.location = url.toString();
    }

    function bulkApprove() { alert('Bulk approve - implement selection and backend call'); }
    function bulkReject() { alert('Bulk reject - implement selection and backend call'); }

    function openFullCalendar() { window.location = '/facility-bookings/calendar'; }

    function proposeSlot(conflictId) {
        alert('Open propose-slot UI for conflict #' + conflictId);
    }

    function exportSchedule(format) {
        // redirect to export endpoint
        const params = new URLSearchParams(window.location.search);
        window.location = `/facility-bookings/export.${format}?` + params.toString();
    }

    function showAllConflicts() {
        window.location = '/facility-bookings?view=conflicts';
    }
</script>
@endsection
