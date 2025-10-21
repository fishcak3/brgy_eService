<?php

namespace App\Http\Controllers\Staff;

use Maatwebsite\Excel\Facades\Excel;  
use App\Imports\ResidentsImport;  
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Resident;
use Carbon\Carbon;

class ResidentsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $sex = $request->input('sex');
        $civilStatus = $request->input('civil_status');
        $barangay = $request->input('barangay');

        $query = Resident::query()
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('fname', 'like', "%{$search}%")
                          ->orWhere('lname', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->orWhere('barangay', 'like', "%{$search}%");
                });
            })
            ->when($role, fn($q) => $q->where('role', $role))
            ->when($sex, fn($q) => $q->where('sex', $sex))
            ->when($civilStatus, fn($q) => $q->where('civil_status', $civilStatus))
            ->when($barangay, fn($q) => $q->where('barangay', $barangay))
            ->orderBy('id', 'desc');

        $residents = $query->paginate(10)->withQueryString();

        $totalResidents = Resident::count();

        $newThisMonth = Resident::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $incompleteProfiles = Resident::where(function ($q) {
                $q->whereNull('birthdate')
                  ->orWhereNull('barangay')
                  ->orWhereNull('civil_status')
                  ->orWhereNull('sex');
            })
            ->count();

        $households = Resident::whereNotNull('household_id')
            ->distinct('household_id')
            ->count();



        $barangays = Resident::whereNotNull('barangay')
            ->distinct()
            ->pluck('barangay');

        return view('userdashboard.staff.residents.index', compact(
            'residents',
            'search',
            'role',
            'sex',
            'civilStatus',
            'barangay',
            'barangays',
            'totalResidents',
            'newThisMonth',
            'incompleteProfiles',
            'households',
        ));
    }

    public function create()
    {
        $barangays = Resident::whereNotNull('barangay')->distinct()->pluck('barangay');
        return view('userdashboard.staff.residents.create', compact('barangays'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'sex' => 'nullable|in:male,female,other',
            'civil_status' => 'nullable|in:single,married,widowed',
            'region' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'municipality' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'sitio' => 'nullable|string|max:255',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Resident::create($validated);

        return redirect()->back()->with('success', 'Resident registered successfully!');
    }

    public function show($id)
    {
        $resident = Resident::findOrFail($id);
        return view('userdashboard.staff.residents.show', compact('resident'));
    }

    public function importResidents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new ResidentsImport, $request->file('file'));
        return redirect()->route('staff.residents.index')
                         ->with('success', 'Residents imported successfully!');
    }

    public function export()
    {
        $fileName = 'residents.csv';
        $residents = Resident::where('role', 'resident')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $columns = [
            'Full Name', 'Email', 'Phone', 'Birthdate', 'Sex', 'Civil Status',
            'Region', 'Province', 'Municipality', 'Barangay', 'Sitio',
            'Purok', 'Household ID', 'Senior Citizen', 'Voter'
        ];

        $callback = function() use ($residents, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($residents as $resident) {
                fputcsv($file, [
                    $resident->name,
                    $resident->email,
                    $resident->phone_number,
                    $resident->birthdate,
                    $resident->sex,
                    $resident->civil_status,
                    $resident->region,
                    $resident->province,
                    $resident->municipality,
                    $resident->barangay,
                    $resident->sitio,
                    $resident->purok,
                    $resident->household_id,
                    $resident->senior_citizen ? 'Yes' : 'No',
                    $resident->voter ? 'Yes' : 'No',
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

}
