<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $requests = DocumentRequest::where('user_id', auth()->id())->latest()->get();
        return view('document_requests.index', compact('requests'));
    }

    public function create()
    {
        return view('document_requests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'request_type' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        DocumentRequest::create([
            'user_id' => auth()->id(),
            'request_type' => $request->request_type,
            'details' => $request->details,
            'status' => 'Pending',
        ]);

        return redirect()->route('document-requests.index')
                         ->with('success', 'Document request submitted successfully.');
    }
}
