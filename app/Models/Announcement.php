<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'created_at'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
