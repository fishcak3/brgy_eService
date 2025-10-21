<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'user_id',
        'position_id',
        'date_start',
        'date_end',
        'is_active',
    ];

    protected $casts = [
        'date_start' => 'date',
        'date_end' => 'date',
        'is_active' => 'boolean',
    ];

    // 🔹 Relationships
    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    // 🔹 Check if the official's term is active
    public function isCurrentlyServing(): bool
    {
        return $this->is_active && ($this->date_end === null || $this->date_end->isFuture());
    }

    // 🔹 Helper: Link a user account to this official
    public function linkUserIfNeeded($userId): void
    {
        if (!$this->user_id) {
            $this->update(['user_id' => $userId]);
        }
    }

    // 🔹 Helper: Check if this official has a linked user account
    public function hasAccount(): bool
    {
        return !is_null($this->user_id);
    }
}
