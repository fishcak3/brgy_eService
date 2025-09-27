<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Models\RequestType;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $requests = DocumentRequest::with('requestType')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('document_requests.index', compact('requests'));
    }

    public function create()
    {
        $requestTypes = RequestType::where('status', 'active')->get();
        return view('document_requests.create', compact('requestTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'request_type_id'    => 'required|exists:request_types,id',
            'purpose'            => 'required|string|max:255',
            'additional_details' => 'nullable|string',
            'priority_level'     => 'required|in:low,medium,high,urgent',
        ]);

        DocumentRequest::create([
            'user_id'         => auth()->id(),
            'request_type_id' => $request->request_type_id,
            'reference_no'    => strtoupper(uniqid('REQ-')), 
            'requested_date'  => now(),
            'priority'        => $request->priority_level,
            'details'         => $request->additional_details,
            'status'          => 'pending',
        ]);
        
        return redirect()->route('document_requests.index')
                         ->with('success', 'Document request submitted successfully.');
    }

    /**
     * Display the specified document request.
     */
    public function show(DocumentRequest $documentRequest)
    {
        // Make sure the user only sees their own request
        if ($documentRequest->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('document_requests.show', compact('documentRequest'));
    }
}
