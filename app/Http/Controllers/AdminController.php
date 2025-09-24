<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Complaint;
use App\Models\ServiceRequest;
use App\Models\Event;

class AdminController extends Controller
{
    public function dashboard()
    {
        $requests = ServiceRequest::all();
        $complaints = Complaint::with('complaintType')->get();
        $announcements = Announcement::all();
        $events = Event::all();

        return view('userdashboard.admin.dashboard', compact('requests', 'complaints', 'announcements', 'events'));
    }
}
