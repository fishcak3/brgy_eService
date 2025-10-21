<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Official;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        // Basic Information
        'fname',
        'mname',
        'lname',
        'suffix',
        'email',
        'password',

        // Role and Contact
        'role',
        'phone_number',

        // Foreign Keys
        'resident_id',  

        // Profile
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate' => 'date',
        'verification_date' => 'date',
        'residency_start_date' => 'date',
        'solo_parent' => 'boolean',
        'ofw' => 'boolean',
        'pwd' => 'boolean',
        'out_of_school_children' => 'boolean',
        'osa' => 'boolean',
        'unemployed' => 'boolean',
        'laborforce' => 'boolean',
        'isy_isc' => 'boolean',
        'senior_citizen' => 'boolean',
        'voter' => 'boolean',
        'residency_verified' => 'boolean',
    ];

    public function getFullNameAttribute()
    {
        return trim("{$this->fname} {$this->mname} {$this->lname} {$this->suffix}");
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->resident_id) {
                $official = Official::where('resident_id', $user->resident_id)->first();

                if ($official && !$official->user_id) {
                    $official->update(['user_id' => $user->id]);
                }
            }
        });
    }
}
