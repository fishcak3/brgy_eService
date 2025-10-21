<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resident;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'request_type_id',
        'reference_no',
        'requested_date',
        'needed_date',
        'status',
        'priority',
        'fee',
        'details',
        'remarks',      
        'assigned_to',
        'completed_at',
    ];

    // ✅ Auto-cast to Carbon instances
    protected $casts = [
        'requested_date' => 'date',
        'needed_date'    => 'date',
        'completed_at'   => 'datetime',
    ];

    // ✅ Relation to RequestType
    public function requestType()
    {
        return $this->belongsTo(RequestType::class, 'request_type_id');
    }

    // ✅ Relation to User (Resident who requested)
    public function resident()
    {
        return $this->belongsTo(resident::class, 'resident_id');
    }


    // ✅ Relation to Staff (assigned staff)
    public function staff()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
