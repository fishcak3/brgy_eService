<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $fillable = [
    'fname', 'mname', 'lname', 'suffix', 'phone_number',
    'birthdate', 'age', 'sex', 'civil_status', 'region', 'province',
    'municipality', 'barangay', 'sitio', 'purok', 'household_id',
    'solo_parent', 'ofw', 'is_pwd', 'is_4ps', 'out_of_school_children',
    'osa', 'unemployed', 'laborforce', 'isy_isc',
    'senior_citizen', 'voter', 'mother_maiden_name',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

}
