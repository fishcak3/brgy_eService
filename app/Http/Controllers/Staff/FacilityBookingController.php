<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\FacilityBooking;
use App\Models\Facility;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FacilityBookingController extends Controller
{
    /**
     * Display the booking management dashboard.
     */
    public function index(Request $request)
    {
        // Fetch all bookings with optional filters
        $bookings = FacilityBooking::with(['facility', 'user'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->date, function ($query, $date) {
                return $query->whereDate('booking_date', $date);
            })
            ->orderBy('booking_date', 'asc')
            ->get();

        // Today's confirmed bookings
        $todayBookings = FacilityBooking::whereDate('booking_date', Carbon::today())
            ->where('status', 'confirmed')
            ->get();

        // Upcoming 3 confirmed bookings
        $upcomingBookings = FacilityBooking::whereDate('booking_date', '>', Carbon::today())
            ->where('status', 'confirmed')
            ->orderBy('booking_date', 'asc')
            ->take(3)
            ->get();

        $facilities = Facility::all();
        
        $requests = FacilityBooking::where('status', 'pending')->get();

        $tomorrowTop = FacilityBooking::whereDate('booking_date', now()->addDay())
            ->where('status', 'confirmed')
            ->orderBy('booking_date', 'asc')
            ->limit(5)
            ->get();

        $flagged = FacilityBooking::where('status', 'pending')->get();

        return view('userdashboard.staff.facility_bookings.index', compact(
            'bookings',
            'todayBookings',
            'upcomingBookings',
            'facilities',
            'requests',
            'tomorrowTop',
            'flagged'
        ));
    }

    /**
     * Approve a booking request.
     */
    public function approve($id)
    {
        $booking = FacilityBooking::findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();

        return back()->with('success', 'Booking approved successfully.');
    }

    /**
     * Reject a booking request.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $booking = FacilityBooking::findOrFail($id);
        $booking->status = 'cancelled';
        $booking->save();

        // Optionally save rejection reason if you add a `rejection_reason` column
        // $booking->rejection_reason = $request->reason;

        return back()->with('success', 'Booking rejected.');
    }

    /**
     * Update booking date/time.
     */
    public function updateDates(Request $request, $id)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $booking = FacilityBooking::findOrFail($id);
        $booking->update($request->only('booking_date', 'start_time', 'end_time'));

        return back()->with('success', 'Booking date/time updated successfully.');
    }

    /**
     * Show booking details.
     */
    public function show($id)
    {
        $booking = FacilityBooking::with(['facility', 'user'])->findOrFail($id);
        return view('userdashboard.staff.facility_bookings.show', compact('booking'));
    }
}
