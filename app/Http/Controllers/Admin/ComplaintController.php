<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with all complaints and eager-load related models
        $query = Complaint::with(['resident', 'complaintType', 'staff']);

        // Optional filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('type')) {
            $query->whereHas('complaintType', function ($q) use ($request) {
                $q->where('name', $request->type);
            });
        }

        // Paginate results
        $complaints = $query->latest()->paginate(10);

        // Officials or staff for assignment dropdown
        $staff = User::whereIn('role', ['staff', 'official'])->get();

        // Pass data to view
        return view('userdashboard.admin.complaints.index', compact('complaints', 'staff'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $complaint = Complaint::with(['resident', 'complaintType', 'staff'])->findOrFail($id);

        return view('userdashboard.admin.complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        $complaint->update($request->only([
            'assigned_to' => $request->assigned_to,
            'status' => $request->status ?? $complaint->status,
        ]));

        return redirect()->back()->with('success', 'Complaint updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
