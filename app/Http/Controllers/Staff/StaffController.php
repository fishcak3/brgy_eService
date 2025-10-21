<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Models\Complaint;
use App\Models\Approval;
use App\Models\Payment;
use App\Models\FacilityBooking;
use App\Models\Broadcast;
use App\Notifications\RequestCreatedNotification;
use App\Notifications\ComplaintUpdatedNotification;

class StaffController extends Controller
{
    /**
     * Staff Dashboard
     */
    public function dashboard()
    {
        $staffId = auth()->id();

        // KPIs
        $kpi = [
            'assigned' => DocumentRequest::where('assigned_to', $staffId)->count(),
            'due_today' => DocumentRequest::where('assigned_to', $staffId)
                ->whereDate('needed_date', today())->count(),
            'overdue' => DocumentRequest::where('assigned_to', $staffId)
                ->whereDate('needed_date', '<', today())->count(),
            'collections_today' => Payment::whereDate('created_at', today())->sum('amount'),
        ];

        // My queue
        $myQueue = DocumentRequest::with(['requestType', 'resident', 'staff'])
            ->where('assigned_to', $staffId)
            ->orderByDesc('requested_date')
            ->paginate(10);

        // statuses for filters
        $statuses = [
            'new','for_validation','for_payment','for_approval',
            'ready_for_pickup','released','rejected','cancelled'
        ];

        // Approvals summary
        $approvals = [
            (object)[
                'title'=>'For Signature (Punong Barangay)',
                'count'=> Approval::whereHas('approver', fn($q) => $q->where('role','punong'))
                    ->whereNull('signed_at')->count(),
                'url'=>'#'
            ],
            (object)[
                'title'=>'For Secretary',
                'count'=> Approval::whereHas('approver', fn($q) => $q->where('role','secretary'))
                    ->whereNull('signed_at')->count(),
                'url'=>'#'
            ],
            (object)[
                'title'=>'For Treasurer',
                'count'=> Approval::whereHas('approver', fn($q) => $q->where('role','treasurer'))
                    ->whereNull('signed_at')->count(),
                'url'=>'#'
            ],
        ];

        // Charts
        $byType = DocumentRequest::selectRaw('request_type_id, count(*) as cnt')
            ->groupBy('request_type_id')
            ->with('requestType')
            ->get()
            ->map(fn($r)=> ['label'=>$r->requestType->name ?? 'N/A','count'=>$r->cnt])
            ->values();

        $bySource = DocumentRequest::selectRaw('source, count(*) as cnt')
            ->groupBy('source')
            ->get()
            ->map(fn($s)=>['label'=>$s->source,'count'=>$s->cnt])
            ->values();

        // Facility bookings
        $nextBookings = FacilityBooking::upcoming()->take(5)->get();

        return view('userdashboard.staff.dashboard', [
            'kpi' => $kpi,
            'myQueue' => $myQueue,
            'statuses' => $statuses,
            'approvals' => $approvals,
            'charts' => ['by_type'=>$byType, 'by_source'=>$bySource],
            'nextBookings' => $nextBookings,
        ]);
    }

    /**
     * Manage Requests Page
     * Added: Summary counters + filters + search
     */
    public function manageRequests(Request $request)
    {
        $staffId = auth()->id();

        // ✅ Filters and Search
        $query = DocumentRequest::with(['requestType', 'resident'])
            ->where('assigned_to', $staffId);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('reference_no', 'like', "%{$searchTerm}%")
                  ->orWhereHas('resident', fn($r) => $r->where('name', 'like', "%{$searchTerm}%"))
                  ->orWhereHas('requestType', fn($t) => $t->where('name', 'like', "%{$searchTerm}%"));
            });
        }

        $requests = $query->latest()->paginate(10);

        // ✅ Summary Counters (for x-summary-card)
        $pendingRequests   = DocumentRequest::where('assigned_to', $staffId)->where('status', 'pending')->count();
        $processingRequests= DocumentRequest::where('assigned_to', $staffId)->where('status', 'processing')->count();
        $approvedRequests  = DocumentRequest::where('assigned_to', $staffId)->where('status', 'approved')->count();
        $rejectedRequests  = DocumentRequest::where('assigned_to', $staffId)->where('status', 'rejected')->count();

        return view('userdashboard.staff.requests.index', compact(
            'requests',
            'pendingRequests',
            'processingRequests',
            'approvedRequests',
            'rejectedRequests'
        ));
    }

    /**
     * Show Single Request
     */
    public function showRequest($id)
    {
        $request = DocumentRequest::with(['requestType', 'resident'])->findOrFail($id);

        if ($request->assigned_to !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('userdashboard.staff.requests.show', compact('request'));
    }

    /**
     * ✅ Update Request Status + Send Notification
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'  => 'required|in:pending,processing,approved,rejected',
            'remarks' => 'nullable|string|max:500',
        ]);

        $docRequest = DocumentRequest::with('resident')->findOrFail($id);

        if ($docRequest->assigned_to !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $docRequest->update([
            'status'  => $request->status,
            'remarks' => $request->remarks,
        ]);

        if ($docRequest->resident) {
            $docRequest->resident->notify(new RequestCreatedNotification([
                'title'        => 'Document Request Status Updated',
                'message'      => "Your request (Ref: {$docRequest->reference_no}) has been updated to: " . ucfirst($docRequest->status),
                'reference_no' => $docRequest->reference_no,
            ]));
        }

        return redirect()->route('staff.requests.index')->with('success', 'Request updated and resident notified.');
    }


    /**
     * ✅ Update Complaint Status + Send Notification
     */
    public function updateComplaintStatus(Request $request, $id)
    {
        $request->validate([
            'status'  => 'required|in:pending,in-progress,resolved,rejected',
            'details' => 'nullable|string|max:500',
        ]);

        $complaint = Complaint::with('resident')->findOrFail($id);

        $complaint->update([
            'status'  => $request->status,
            'details' => $request->details,
        ]);

        if ($complaint->resident) {
            $complaint->resident->notify(new ComplaintUpdatedNotification([
                'title'        => 'Complaint Status Updated',
                'message'      => "Your complaint (Ref: {$complaint->reference_no}) has been updated to: " . ucfirst($complaint->status),
                'reference_no' => $complaint->reference_no,
            ]));
        }

        return redirect()->back()->with('success', 'Complaint status updated and resident notified.');
    }

    /**
     * Reports Page
     */
    public function reports()
    {
        $staffId = auth()->id();

        $requests = DocumentRequest::with('requestType')
            ->where('assigned_to', $staffId)
            ->get();

        return view('userdashboard.staff.reports.index', compact('requests'));
    }

    /**
     * Generate Report (Filter by Date)
     */
    public function generateReport(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to'   => 'required|date|after_or_equal:from',
        ]);

        $staffId = auth()->id();

        $reports = DocumentRequest::with('requestType')
            ->where('assigned_to', $staffId)
            ->whereBetween('requested_date', [$request->from, $request->to])
            ->get();

        return view('userdashboard.staff.reports.result', compact('reports'));
    }
}
