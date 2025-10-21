<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Resident;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with(['position', 'resident'])->latest()->paginate(10);
        return view('userdashboard.admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     * Includes residents for selection to auto-fill data.
     */
    public function create()
    {
        $positions = Position::all();
        $residents = Resident::orderBy('lname')->get();

        return view('userdashboard.admin.users.create', compact('positions', 'residents'));
    }

    public function searchResidents(Request $request)
    {
        $term = $request->input('term', '');

        $residents = \App\Models\Resident::query()
            ->where('lname', 'like', "%{$term}%")
            ->orWhere('fname', 'like', "%{$term}%")
            ->orderBy('lname')
            ->limit(20)
            ->get(['id', 'fname', 'lname']);

        $results = $residents->map(function ($resident) {
            return [
                'id' => $resident->id,
                'text' => "{$resident->lname}, {$resident->fname}",
            ];
        });

        return response()->json($results);
    }


    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,staff,resident',
            'password' => 'required|string|min:8',
        ]);

        // ✅ Step 1: Update resident info if modified
        $resident = Resident::findOrFail($request->resident_id);
        $resident->update([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'suffix' => $request->suffix,
        ]);

        // ✅ Step 2: Create the user account
        $user = User::create([
            'resident_id' => $resident->id,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User account created successfully and resident info updated.');
    }

    /**
     * Fetch resident details (AJAX) for autofill in user creation form.
     */
    public function details($id)
    {
        $resident = Resident::findOrFail($id);

        return response()->json([
            'fname' => $resident->fname,
            'mname' => $resident->mname,
            'lname' => $resident->lname,
            'suffix' => $resident->suffix,
            'phone_number' => $resident->phone_number,
            'birthdate' => $resident->birthdate ? $resident->birthdate->format('Y-m-d') : null,
            'sex' => $resident->sex,
            'civil_status' => $resident->civil_status,
            'region' => $resident->region,
            'province' => $resident->province,
            'municipality' => $resident->municipality,
            'barangay' => $resident->barangay,
            'street' => $resident->street,
            'zone' => $resident->zone,
            'household_id' => $resident->household_id,
        ]);
    }


    /**
     * Show the form for editing an existing user.
     */
    public function edit(User $user)
    {
        $positions = Position::all();
        $residents = Resident::orderBy('lname')->get();

        return view('userdashboard.admin.users.edit', compact('user', 'positions', 'residents'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,staff,resident',
            'resident_id' => 'nullable|exists:residents,id',
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'position_id' => 'nullable|exists:positions,id',
            'term_start' => 'nullable|date',
            'term_end' => 'nullable|date|after_or_equal:term_start',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->update([
            'resident_id' => $request->resident_id,
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'suffix' => $request->suffix,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'position_id' => $request->position_id,
            'term_start' => $request->term_start,
            'term_end' => $request->term_end,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $user->password,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }
}
