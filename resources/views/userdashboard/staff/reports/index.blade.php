@extends('layouts.sidebar')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-semibold text-dark">
        📊 Analytics & Reports
    </h2>

    <!-- 🔍 Filter Form -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('staff.reports.generate') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label for="from" class="form-label fw-semibold">From Date</label>
                    <input type="date" name="from" id="from" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="to" class="form-label fw-semibold">To Date</label>
                    <input type="date" name="to" id="to" class="form-control" required>
                </div>
                <div class="col-md-4 align-self-end">
                    <button type="submit" class="btn btn-success w-100 shadow-sm">
                        <i class="bi bi-bar-chart-line me-1"></i> Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 📈 Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card text-bg-primary shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Total Requests</h6>
                    <h2 class="fw-bold">{{ $requests->count() ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-bg-warning shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Pending</h6>
                    <h2 class="fw-bold">{{ $requests->where('status','pending')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-bg-success shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Approved</h6>
                    <h2 class="fw-bold">{{ $requests->where('status','approved')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-bg-danger shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="fw-semibold">Rejected</h6>
                    <h2 class="fw-bold">{{ $requests->where('status','rejected')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- 📋 Data Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Request Summary</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Ref No</th>
                            <th>Type</th>
                            <th>Resident</th>
                            <th>Status</th>
                            <th>Requested Date</th>
                            <th>Needed Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                            <tr>
                                <td>{{ $req->reference_no }}</td>
                                <td>{{ $req->requestType->name ?? 'N/A' }}</td>
                                <td>{{ $req->resident->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $req->status == 'approved' ? 'success' : ($req->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($req->status) }}
                                    </span>
                                </td>
                                <td>{{ $req->requested_date->format('Y-m-d') }}</td>
                                <td>{{ $req->needed_date ? $req->needed_date->format('Y-m-d') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No requests found for this period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Optional Chart.js Integration -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Future analytics chart example
</script>
@endpush
@endsection
