<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentRequest; 

class ReportController extends Controller
{
    public function index()
    {
        $requests = DocumentRequest::latest()->get();

        return view('userdashboard.staff.reports.index', compact('requests'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to'   => 'required|date|after_or_equal:from',
        ]);

        $requests = DocumentRequest::whereBetween('requested_date', [$request->from, $request->to])
            ->latest()
            ->get();

        return view('userdashboard.staff.reports.index', compact('requests'))
            ->with('from', $request->from)
            ->with('to', $request->to);
    }
}
