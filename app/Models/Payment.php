<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'document_request_id', // link to request
        'user_id',             // resident who paid
        'amount',
        'status',              // paid, pending, failed, refunded
        'method',              // cash, gcash, bank, etc.
        'or_number',
        'remarks',
        'paid_at',
    ];

    protected $dates = [
        'paid_at',
    ];

    // Relationships
    public function request()
    {
        return $this->belongsTo(DocumentRequest::class, 'document_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
