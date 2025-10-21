<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Official;
use App\Models\Resident;
use App\Models\User;
use App\Models\Position;
use App\Models\TermEnd;
use Illuminate\Http\Request;

class OfficialController extends Controller
{
    public function index()
    {
        $officials = Official::with(['resident', 'position'])->get();
        return view('userdashboard.admin.officials.index', compact('officials'));
    }

    public function create()
    {
        $residents = Resident::orderBy('lname')->get();
        $positions = Position::orderBy('title')->get();
        return view('userdashboard.admin.officials.create', compact('residents', 'positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'position_id' => 'required|exists:positions,id',
            'date_start' => 'required|date',
            'date_end' => 'nullable|date|after:date_start',
            'is_active' => 'required|boolean',
        ]);

        $user = User::where('resident_id', $validated['resident_id'])->first();

        $validated['user_id'] = $user ? $user->id : null;

        Official::create($validated);

        return redirect()->route('admin.officials.index')->with('success', 'Official assigned successfully!');
    }

    public function destroy($id)
    {
        $official = Official::with(['resident', 'position'])->findOrFail($id);

        // Save to term_ends before deletion
        TermEnd::create([
            'official_id' => $official->id,
            'name' => $official->resident
                ? $official->resident->lname . ', ' . $official->resident->fname
                : 'Unknown',
            'position' => $official->position->title ?? 'Unknown',
            'start_date' => $official->date_start,
            'end_date' => now(),
            'reason' => 'deleted',
        ]);

        // Now delete without cascading the new term_ends record
        $official->delete();

        return redirect()->route('admin.officials.index')
            ->with('success', 'Official deleted and moved to Term End records.');
    }

    public function endTermIndex()
    {
        // ✅ Fetch from term_ends table instead of officials
        $termEnds = TermEnd::orderBy('end_date', 'desc')->get();

        return view('userdashboard.admin.officials.endterm', compact('termEnds'));
    }

    public function show($id)
    {
        if ($id === 'end-term') {
            return redirect()->route('admin.officials.endTerm.index');
        }

        $official = Official::findOrFail($id);
        return view('admin.officials.show', compact('official'));
    }

    public function endTerm($id)
    {
        $official = Official::with(['resident', 'position'])->findOrFail($id);

        TermEnd::create([
            'official_id' => $official->id,
            'name' => $official->resident
                ? $official->resident->lname . ', ' . $official->resident->fname
                : 'Unknown',
            'position' => $official->position->title ?? 'Unknown',
            'start_date' => $official->date_start,
            'end_date' => now(),
            'reason' => 'term_ended',
        ]);

        $official->delete();

        return redirect()->route('admin.officials.index')
            ->with('success', 'Official term ended and recorded successfully.');
    }

    public function destroyTermEnd($id)
    {
        $termEnd = TermEnd::findOrFail($id);
        $termEnd->delete();

        return redirect()->route('admin.officials.endTerm.index')
            ->with('success', 'Term end record deleted successfully.');
    }

}
