<?php

namespace App\Imports;

use App\Models\Resident;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ResidentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Normalize keys (make lowercase + trim spaces)
        $row = array_change_key_case(array_map('trim', $row));

        // Helper function to safely get column values
        $get = function ($keys, $default = null) use ($row) {
            foreach ((array) $keys as $key) {
                if (array_key_exists($key, $row) && $row[$key] !== null && $row[$key] !== '') {
                    return $row[$key];
                }
            }
            return $default;
        };

        // Skip empty rows (no name)
        if (!$get(['first_name', 'fname', 'first name']) || !$get(['last_name', 'lname', 'last name'])) {
            return null;
        }

        try {
            return new Resident([
                'fname' => trim($get(['first_name', 'fname', 'first name'])),
                'mname' => trim($get(['middle_name', 'mname', 'middle name'])),
                'lname' => trim($get(['last_name', 'lname', 'last name'])),
                'suffix' => trim($get(['suffix'])),

                'phone_number' => $get(['phone_number', 'contact', 'phone']),
                'age' => $this->toInt($get(['age'])),
                'sex' => $this->normalizeSex($get(['sex', 'gender'])),
                'civil_status' => strtolower(trim($get(['civil_status', 'civil status']))),

                // Address info
                'region' => $get(['region']),
                'province' => $get(['province']),
                'municipality' => $get(['municipality', 'city']),
                'barangay' => $get(['barangay']),
                'street' => $get(['street']),
                'household_id' => $get(['household_id']),
                'zone' => $get(['zone']),

                // Sectoral classification
                'solo_parent' => $this->toBool($get(['solo_parent'])),
                'ofw' => $this->toBool($get(['ofw'])),
                'is_pwd' => $this->toBool($get(['is_pwd', 'pwd'])),
                'is_4ps' => $this->toBool($get(['is_4ps', '4ps'])),
                'out_of_school_children' => $this->toBool($get(['out_of_school_children', 'osc'])),
                'osa' => $this->toBool($get(['osa'])),
                'unemployed' => $this->toBool($get(['unemployed'])),
                'laborforce' => $this->toBool($get(['laborforce'])),
                'isy_isc' => $this->toBool($get(['isy_isc'])),

                // Other flags
                'senior_citizen' => $this->toBool($get(['senior_citizen'])),
                'voter' => $this->toBool($get(['voter'])),

                // Family & personal
                'mother_maiden_name' => $get(['mother_maiden_name', 'maiden_name']),
                'birthdate' => $this->parseDate($get(['birthdate', 'bdate'])),
            ]);
        } catch (\Exception $e) {
            // Optional: log errors for debugging
            Log::error('Resident import failed', [
                'error' => $e->getMessage(),
                'row' => $row,
            ]);
            return null;
        }
    }

    private function toBool($value): bool
    {
        if (is_null($value)) return false;
        $val = strtolower(trim($value));
        return in_array($val, ['1', 'yes', 'true', 'y', 't', '✓']);
    }

    private function toInt($value)
    {
        return is_numeric($value) ? (int) $value : null;
    }

    private function normalizeSex($value)
    {
        if (!$value) return null;
        $val = strtolower(trim($value));
        if (in_array($val, ['m', 'male'])) return 'male';
        if (in_array($val, ['f', 'female'])) return 'female';
        return $val;
    }

    private function parseDate($value)
    {
        if (!$value) return null;
        try {
            if (is_numeric($value)) {
                return Carbon::instance(Date::excelToDateTimeObject($value))->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
