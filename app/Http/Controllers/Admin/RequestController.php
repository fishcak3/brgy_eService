<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
    public function index(HttpRequest $request)
    {
        $query = DocumentRequest::with(['resident', 'staff']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('urgency')) {
            $query->where('urgency', $request->urgency);
        }

        $requests = $query->latest()->paginate(10);
        $officials = User::whereIn('role', ['staff', 'official'])->get();

        return view('userdashboard.admin.requests.index', compact('requests', 'officials'));
    }

    public function show($id)
    {
        $documentRequest = DocumentRequest::with(['resident', 'staff', 'requestType'])->findOrFail($id);
        return view('userdashboard.admin.requests.show', compact('documentRequest'));
    }


    public function update(HttpRequest $request, $id)
    {
        $documentRequest = DocumentRequest::findOrFail($id);

        // Determine new status logic
        $newStatus = $request->status;

        // If assigning a staff and current status is still "pending" or "open",
        // automatically mark it as "assigned"
        if ($request->filled('assigned_to') && in_array($documentRequest->status, ['pending', 'open'])) {
            $newStatus = 'assigned';
        }

        $documentRequest->update([
            'assigned_to' => $request->assigned_to,
            'status' => $newStatus,
            'notes' => $request->notes,
            'deadline' => $request->deadline,
        ]);

        return back()->with('success', 'Request updated successfully!');
    }
}
