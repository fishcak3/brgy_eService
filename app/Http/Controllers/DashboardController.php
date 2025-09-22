<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\Complaint;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role; // assuming you have a 'role' column in users table

        // Common data for all dashboards
        $announcements = Announcement::latest()->take(5)->get();

        // Different data depending on role
        if ($role === 'admin') {
            $requests   = ServiceRequest::latest()->get();
            $complaints = Complaint::latest()->get();
            return view('userdashboard.admin.dashboard', compact('requests', 'complaints', 'announcements'));
        
        } elseif ($role === 'staff') {
            $requests   = ServiceRequest::where('assigned_to', $user->id)->latest()->get();
            $complaints = Complaint::where('assigned_to', $user->id)->latest()->get();
            return view('userdashboard.staff.dashboard', compact('requests', 'complaints', 'announcements'));
        
        } else { // resident
            $requests   = ServiceRequest::where('user_id', $user->id)->latest()->get();
            $complaints = Complaint::where('user_id', $user->id)->latest()->get();
            return view('userdashboard.resident.dashboard', compact('requests', 'complaints', 'announcements'));
        }
    }
}
