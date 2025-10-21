<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Models\RequestType;
use App\Models\User;
use App\Notifications\RequestCreatedNotification;
use App\Notifications\RequestUpdatedNotification;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $requests = DocumentRequest::with('requestType')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('userdashboard.resident.document_requests.index', compact('requests'));
    }

    public function create()
    {
        $requestTypes = RequestType::where('status', 'active')->get();
        return view('userdashboard.resident.document_requests.create', compact('requestTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'request_type_id'    => 'required|exists:request_types,id',
            'purpose'            => 'required|string|max:255',
            'additional_details' => 'nullable|string',
            'priority_level'     => 'required|in:low,medium,high,urgent',
        ]);

        $documentRequest = DocumentRequest::create([
            'user_id'         => auth()->id(),
            'request_type_id' => $request->request_type_id,
            'reference_no'    => strtoupper(uniqid('REQ-')),
            'requested_date'  => now(),
            'priority'        => $request->priority_level,
            'details'         => $request->additional_details,
            'status'          => 'open',
        ]);

        // ✅ Notify admins & staff
        $adminsAndStaff = User::whereIn('role', ['admin', 'staff'])->get();
        foreach ($adminsAndStaff as $user) {
            $user->notify(new RequestCreatedNotification([
                'title'       => 'New Document Request',
                'message'     => 'Document request (Ref: ' . $documentRequest->reference_no . ') was submitted by ' . auth()->user()->name,
                'reference_no'=> $documentRequest->reference_no,
                'type'        => 'document_request'
            ]));
        }

        return redirect()->route('resident.document-requests.index')
                         ->with('success', 'Document request submitted successfully.');
    }

    public function show(DocumentRequest $documentRequest)
    {
        if ($documentRequest->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('userdashboard.resident.document_requests.show', compact('documentRequest'));
    }

    public function updateStatus(Request $request, DocumentRequest $documentRequest)
    {
        $request->validate([
            'status'  => 'required|in:pending,processing,approved,rejected',
            'details' => 'nullable|string|max:500',
        ]);

        $documentRequest->update([
            'status'  => $request->status,
            'details' => $request->details,
        ]);

        // ✅ Notify the owner
        $documentRequest->user->notify(new RequestUpdatedNotification([
            'title'       => 'Document Request Update',
            'message'     => 'Your request (Ref: ' . $documentRequest->reference_no . ') is now "' . ucfirst($request->status) . '".',
            'reference_no'=> $documentRequest->reference_no,
            'type'        => 'document_request'
        ]));

        return redirect()->back()->with('success', 'Document request updated successfully.');
    }

    // ✅ Staff Dashboard
    public function staffDashboard()
    {
        $pendingRequests = DocumentRequest::where('status', 'pending')->count();

        $approvedToday = DocumentRequest::where('status', 'approved')
            ->whereDate('updated_at', today())
            ->count();

        $residentsCount = User::where('role', 'resident')->count();

        $recentRequests = DocumentRequest::with('requestType', 'user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.staff', compact(
            'pendingRequests',
            'approvedToday',
            'residentsCount',
            'recentRequests'
        ));
    }
}
