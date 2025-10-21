<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\ComplaintType;
use App\Models\User;
use App\Notifications\ComplaintUpdatedNotification;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with(['complaintType'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('userdashboard.resident.complaints.index', compact('complaints'));
    }

    public function create()
    {
        $complaintTypes = ComplaintType::all();
        return view('userdashboard.resident.complaints.create', compact('complaintTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'complaint_type_id' => 'required|exists:complaint_types,id',
            'location'          => 'nullable|string|max:255',
            'priority'          => 'required|in:low,medium,high,urgent',
            'details'           => 'required|string',
            'contact_info'      => 'nullable|string|max:255',
        ]);

        $complaint = Complaint::create([
            'user_id'           => auth()->id(),
            'complaint_type_id' => $request->complaint_type_id,
            'reference_no'      => strtoupper(uniqid('CMP-')),
            'location'          => $request->location,
            'priority'          => $request->priority,
            'details'           => $request->details,
            'status'            => 'open',
            'remarks'           => null,
        ]);

        // ✅ Notify admins and staff properly
        $adminsAndStaff = User::whereIn('role', ['admin', 'staff'])->get();
        foreach ($adminsAndStaff as $user) {
            $user->notify(new ComplaintUpdatedNotification([
                'title'        => 'New Complaint Filed',
                'message'      => 'Complaint (' . $complaint->reference_no . ') of type "' 
                                   . $complaint->complaintType->name . '" was filed by ' 
                                   . auth()->user()->name,
                'reference_no' => $complaint->reference_no,
            ]));
        }

        return redirect()->route('resident.complaints.index')
                         ->with('success', 'Complaint filed successfully.');
    }

    public function show(Complaint $complaint)
    {
        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $complaint->load(['complaintType', 'staff', 'resident']);
        return view('complaints.show', compact('complaint'));
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status'  => 'required|in:open,in-progress,resolved,rejected',
            'remarks' => 'nullable|string|max:500',
        ]);

        $complaint->update([
            'status'  => $request->status,
            'remarks' => $request->remarks,
        ]);

        // ✅ Notify resident who filed the complaint
        $complaint->resident?->notify(new ComplaintUpdatedNotification([
            'title'        => 'Complaint Status Updated',
            'message'      => "Your complaint (Ref: {$complaint->reference_no}) has been updated to: " . ucfirst($complaint->status),
            'reference_no' => $complaint->reference_no,
        ]));

        return redirect()->back()->with('success', 'Complaint status updated successfully.');
    }
}
