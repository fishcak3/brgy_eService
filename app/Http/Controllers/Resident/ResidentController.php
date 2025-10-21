<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Complaint;
use App\Models\DocumentRequest;
use Illuminate\Support\Facades\Auth;

class ResidentController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id(); // current logged-in resident

        $complaints = Complaint::with('complaintType')
            ->where('user_id', $userId) // only this resident's complaints
            ->latest()
            ->take(3)
            ->get();

        $requests = DocumentRequest::with('requestType')
            ->where('user_id', $userId) // only this resident's document requests
            ->latest()
            ->take(3)
            ->get();

        return view('userdashboard.resident.dashboard', compact('complaints', 'requests'));
    }
}
