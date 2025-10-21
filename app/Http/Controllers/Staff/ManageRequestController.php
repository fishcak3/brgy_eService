<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Models\Resident;
use \App\Models\RequestType;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ManageRequestController extends Controller
{
    public function manageRequests(Request $request)
    {
        $query = DocumentRequest::with(['resident', 'requestType']);

        if ($request->filled('date_range')) {
            if ($request->date_range === '7_days') {
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
            } elseif ($request->date_range === 'this_month') {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            } elseif ($request->date_range === '3_months') {
                $query->where('created_at', '>=', Carbon::now()->subMonths(3));
            }
        }

        if ($request->filled('category')) {
            $query->where('request_type_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference_no', 'like', "%{$search}%")
                  ->orWhereHas('resident', function ($r) use ($search) {
                      $r->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(10);

        $pendingRequests = DocumentRequest::where('status', 'pending')->count();
        $approvedToday = DocumentRequest::where('status', 'approved')
            ->whereDate('updated_at', Carbon::today())->count();
        $completedThisMonth = DocumentRequest::where('status', 'completed')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)->count();
        $overdueRequests = DocumentRequest::where('status', 'pending')
            ->where('created_at', '<', Carbon::now()->subDays(7))->count();

        $requestTypes = DocumentRequest::select('request_type_id')->distinct()->pluck('request_type_id');
        $statuses = DocumentRequest::select('status')->distinct()->pluck('status');

        return view('userdashboard.staff.requests.index', compact(
            'requests',
            'pendingRequests',
            'approvedToday',
            'completedThisMonth',
            'overdueRequests',
            'requestTypes',
            'statuses'
        ));
    }

    public function createWalkin()
    {
        $requestTypes = RequestType::all();

        return view('userdashboard.staff.requests.create', compact('requestTypes'));
    }

    public function storeWalkin(Request $request)
    {
        $validated = $request->validate([
            'resident_name' => 'required|string|max:255',
            'request_type_id' => 'required|exists:request_types,id',
            'needed_date' => 'nullable|date',
            'details' => 'nullable|string',
        ]);


        DocumentRequest::create([
            'user_id' => null, 
            'request_type_id' => $validated['request_type_id'],
            'reference_no' => strtoupper('WR-' . uniqid()),
            'requested_date' => now(),
            'needed_date' => $validated['needed_date'],
            'source' => 'walk-in',
            'status' => 'pending',
            'priority' => 'medium',
            'fee' => 0,
            'details' => $validated['details'] ?? null,
            'remarks' => null,
        ]);

        return redirect()->route('userdashboard.staff.requests.index')->with('success', 'Walk-in request created successfully.');
    }


    public function showRequest($id)
    {
        $request = DocumentRequest::with(['resident', 'requestType'])->findOrFail($id);
        return view('userdashboard.staff.requests.show', compact('request'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);

        $docRequest = DocumentRequest::findOrFail($id);
        $docRequest->status = $request->status;
        $docRequest->save();

        return redirect()->back()->with('success', 'Request status updated successfully.');
    }


}
