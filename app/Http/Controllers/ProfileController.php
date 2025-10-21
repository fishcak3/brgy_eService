<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    // ✅ Show My Profile (index page)
    public function index()
    {
        $user = auth()->user();
        return view('profile.index', compact('user'));
    }

    /**
     * ✅ Quick Update via Modal (AJAX)
     * Handles individual section updates: personal, contact, identity, sectoral.
     */
    public function quickUpdate(Request $request)
    {
        $user = Auth::user();
        $section = $request->input('section');

        switch ($section) {
            case 'personal':
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'birthdate' => 'nullable|date',
                    'sex' => 'nullable|in:male,female,other',
                    'civil_status' => 'nullable|in:single,married,widowed',
                ]);
                break;

            case 'contact':
                $validated = $request->validate([
                    'email' => 'required|email|unique:users,email,' . $user->id,
                    'phone_number' => 'nullable|string|max:20',
                    'region' => 'nullable|string|max:255',
                    'province' => 'nullable|string|max:255',
                    'municipality' => 'nullable|string|max:255',
                    'barangay' => 'nullable|string|max:255',
                    'sitio' => 'nullable|string|max:255',
                ]);
                break;

            case 'identity':
                $validated = $request->validate([
                    'household_no' => 'nullable|string|max:50',
                    'purok' => 'nullable|string|max:50',
                    'photo' => 'nullable|image|max:2048',
                ]);

                if ($request->hasFile('photo')) {
                    $validated['photo'] = $request->file('photo')->store('profile_photos', 'public');
                }
                break;

            case 'sectoral':
                $validated = $request->validate([
                    'solo_parent' => 'boolean',
                    'ofw' => 'boolean',
                    'pwd' => 'boolean',
                    'out_of_school_children' => 'boolean',
                    'osa' => 'boolean',
                    'unemployed' => 'boolean',
                    'laborforce' => 'boolean',
                    'isy_isc' => 'boolean',
                    'senior_citizen' => 'boolean',
                    'voter' => 'boolean',
                ]);
                break;

            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid section specified.'
                ], 400);
        }

        $user->update($validated);

        // ✅ Audit trail logging
        Log::info('Quick profile update performed', [
            'user_id' => $user->id,
            'section' => $section,
            'updated_fields' => array_keys($validated),
            'updated_by' => $user->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => ucfirst($section) . ' information updated successfully.',
        ]);
    }

    // ✅ Full profile edit page
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    // ✅ Full profile update (non-modal)
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

    // ✅ Delete account
    public function destroy(Request $request)
    {
        $user = Auth::user();
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}
