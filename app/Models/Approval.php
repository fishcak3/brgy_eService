<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Approval extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'document_request_id',  // Which request is being approved
        'approver_id',          // User (staff/admin) assigned to approve
        'status',               // pending, approved, rejected, signed
        'remarks',
        'signed_at',
    ];

    protected $dates = ['signed_at'];

    // Relationships
    public function request()
    {
        return $this->belongsTo(DocumentRequest::class, 'document_request_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
