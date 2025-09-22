<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'request_type',
        'status',
        'priority',
        'details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
