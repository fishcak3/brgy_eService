<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'is_active', 'max_members'];

    public function user()
    {
        return $this->hasOne(User::class, 'position_id');
    }
}
