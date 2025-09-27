<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\ComplaintType;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('complaintType')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('complaints.index', compact('complaints'));
    }

    public function create()
    {
        $complaintTypes = ComplaintType::all();
        return view('complaints.create', compact('complaintTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'complaint_type_id' => 'required|exists:complaint_types,id',
            'location'          => 'nullable|string|max:255',
            'priority'          => 'required|in:low,medium,high,urgent',
            'details'           => 'required|string',
            'contact_info'      => 'nullable|string|max:255',
        ]);

        Complaint::create([
            'user_id'           => auth()->id(),
            'complaint_type_id' => $request->complaint_type_id,
            'reference_no'      => strtoupper(uniqid('CMP-')),
            'location'          => $request->location,
            'priority'          => $request->priority,
            'details'           => $request->details,
            'status'            => 'open',
            'remarks'           => null,
        ]);

        return redirect()->route('complaints.index')
                         ->with('success', 'Complaint filed successfully.');
    }

    /**
     * Display a specific complaint.
     */
    public function show(Complaint $complaint)
    {
        // Ensure residents can only view their own complaints
        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

            // Eager load relationships (type + staff)
        $complaint->load(['complaintType', 'staff']);

        return view('complaints.show', compact('complaint'));
    }
}
