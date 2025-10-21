<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\RequestCreatedNotification;
use App\Notifications\RequestUpdatedNotification;

class NotificationService
{
    public static function notifyAdminsAndStaff($data)
    {
        $users = User::whereIn('role', ['admin', 'staff'])->get();
        foreach ($users as $user) {
            $user->notify(new RequestCreatedNotification($data));
        }
    }

    public static function notifyResident($resident, $data)
    {
        $resident->notify(new RequestUpdatedNotification($data));
    }
}
