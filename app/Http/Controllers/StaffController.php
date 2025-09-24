<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Complaint;
use App\Models\ServiceRequest;
use App\Models\Event;

class StaffController extends Controller
{
    public function dashboard()
    {
        $requests = ServiceRequest::latest()->get();
        $complaints = Complaint::with('complaintType')->latest()->get();
        $announcements = Announcement::latest('published_at')->take(5)->get();
        $events = Event::whereDate('date', '>=', now())
                       ->orderBy('date')
                       ->take(5)
                       ->get();

        return view('userdashboard.staff.dashboard', compact('requests', 'complaints', 'announcements', 'events'));
    }
}
