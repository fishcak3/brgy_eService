<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'complaint_type_id',
        'title',
        'reference_no',
        'location',
        'priority',
        'status',
        'details',
        'remarks',
        'assigned_to',
        'resolved_at'
    ];

    /**
     * Relationship: Complaint belongs to a Resident (User).
     */
    public function resident()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: Complaint belongs to a Type.
     */
    public function complaintType()
    {
        return $this->belongsTo(ComplaintType::class, 'complaint_type_id');
    }

    /**
     * Relationship: Complaint assigned to a Staff (User).
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
