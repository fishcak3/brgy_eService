<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermEnd extends Model
{
    use HasFactory;

    protected $fillable = [
        'official_id',
        'name',
        'position',
        'start_date',
        'end_date',
        'reason',
    ];

    public function official()
    {
        return $this->belongsTo(Official::class);
    }
}
