<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\User;
use App\Models\ComplaintType;

class ManageComplaintController extends Controller
{
    /**
     * Display all complaints with related user and type data.
     */
    public function index()
    {
        // Fetch all complaints with relations (user and complaint type)
        $complaints = Complaint::with(['user', 'type', 'assignedStaff'])
            ->latest()
            ->get();

        // Compute summary counts
        $summary = [
            'new' => Complaint::where('status', 'open')->count(),
            'in_progress' => Complaint::where('status', 'in-progress')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
        ];

        return view('staff.complaints.index', compact('complaints', 'summary'));
    }

        /**
     * Manage Complaints Page
     */
    public function manageComplaints()
    {
        $complaints = Complaint::with(['resident', 'complaintType', 'staff'])
            ->latest()
            ->paginate(10);

        return view('userdashboard.staff.complaints.index', compact('complaints'));
    }

    /**
     * Show details for a specific complaint.
     */
    public function show($id)
    {
        $complaint = Complaint::with(['user', 'type', 'assignedStaff'])->findOrFail($id);
        return view('staff.complaints.show', compact('complaint'));
    }
}
