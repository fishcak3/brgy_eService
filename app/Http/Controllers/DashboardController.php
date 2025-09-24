<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequest;
use App\Models\Complaint;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\DocumentRequest; // ✅ Add this missing import

class DashboardController extends Controller
{
    public function resident()
    {
        $userId = Auth::id();

        // Latest announcements (limit 5)
        $announcements = Announcement::latest('published_at')->take(5)->get();

        // Complaints only by this resident
        $complaints = Complaint::with('complaintType')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // Document requests only by this resident
        $requests = DocumentRequest::with('requestType')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // Upcoming events
        $events = Event::whereDate('date', '>=', now())
            ->orderBy('date')
            ->take(5)
            ->get();

        // ✅ make sure the blade path matches your folder
        return view('userdashboard.resident.dashboard', compact('announcements', 'complaints', 'requests', 'events'));
    }

    public function staff()
    {
        // Staff sees all
        $requests = ServiceRequest::all();
        $complaints = Complaint::all();
        $announcements = Announcement::latest()->take(5)->get();
        $events = Event::whereDate('date', '>=', now())->orderBy('date')->take(5)->get();

        return view('staff', compact('requests', 'complaints', 'announcements', 'events'));
    }

    public function admin()
    {
        // Admin has full control
        $requests = ServiceRequest::all();
        $complaints = Complaint::all();
        $announcements = Announcement::all();
        $events = Event::all();

        return view('admin', compact('requests', 'complaints', 'announcements', 'events'));
    }
}
