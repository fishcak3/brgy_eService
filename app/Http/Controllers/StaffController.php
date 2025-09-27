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

        return view('userdashboard.staff.dashboard');
    }
}
