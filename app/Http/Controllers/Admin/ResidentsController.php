<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ResidentsImport;

class ResidentsController extends Controller
{
    /**
     * Display a listing of residents.
     */
    public function index()
    {
        $residents = Resident::orderBy('lname')->paginate(10);

        
        return view('userdashboard.admin.residents.index', compact('residents'));
    }

    /**
     * Display a single resident’s details.
     */
    public function show(Resident $resident)
    {
        return view('userdashboard.admin.residents.show', compact('resident'));
    }

    public function create()
    {
        return view('userdashboard.admin.residents.create');
    }

        public function store(Request $request)
    {
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'phone_number' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'age' => 'nullable|integer',
            'sex' => 'nullable|in:male,female,other',
            'civil_status' => 'nullable|in:single,married,widowed',
            'region' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'municipality' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'sitio' => 'nullable|string|max:255',
            'purok' => 'nullable|string|max:255',
            'household_id' => 'nullable|string|max:255',
            'solo_parent' => 'nullable|boolean',
            'ofw' => 'nullable|boolean',
            'is_pwd' => 'nullable|boolean',
            'is_4ps' => 'nullable|boolean',
            'out_of_school_children' => 'nullable|boolean',
            'osa' => 'nullable|boolean',
            'unemployed' => 'nullable|boolean',
            'laborforce' => 'nullable|boolean',
            'isy_isc' => 'nullable|boolean',
            'senior_citizen' => 'nullable|boolean',
            'voter' => 'nullable|boolean',
            'mother_maiden_name' => 'nullable|string|max:255',
        ]);

        // Convert checkboxes to booleans (since unchecked ones are missing)
        $booleanFields = [
            'solo_parent', 'ofw', 'is_pwd', 'is_4ps',
            'out_of_school_children', 'osa', 'unemployed',
            'laborforce', 'isy_isc', 'senior_citizen', 'voter',
        ];

        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field);
        }

        Resident::create($validated);

        return redirect()
            ->route('admin.residents.create')
            ->with('success', 'Resident added successfully!');
    }

    public function edit($id)
    {
        $resident = Resident::findOrFail($id);

        return view('userdashboard.admin.residents.edit', compact('resident'));
    }

    public function update(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);

        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            // add more fields here...
        ]);

        $resident->update($validated);

        return redirect()->route('admin.residents.index')
                        ->with('success', 'Resident updated successfully.');
    }


    public function destroy($id)
    {
        $resident = Resident::findOrFail($id);
        $resident->delete();

        return redirect()->route('admin.residents.index')
                        ->with('success', 'Resident deleted successfully.');
    }


    /**
     * Import residents from an Excel or CSV file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:5120', // up to 5MB
        ]);

        try {
            Excel::import(new ResidentsImport, $request->file('file'));
            return back()->with('success', 'Residents imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
