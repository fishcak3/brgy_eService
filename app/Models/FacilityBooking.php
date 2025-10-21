<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_id',
        'user_id',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'payment_status',
    ];

    public function scopeUpcoming($query)
    {
        return $query->whereDate('booking_date', '>=', now())
                     ->orderBy('booking_date')
                     ->orderBy('start_time');
    }

    // Relationships
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
