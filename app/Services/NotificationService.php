<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Account;

class NotificationService
{
    public function createNotification($title, $description)
    {
        $notification = Notification::create([
            'title' => $title,
            'description' => $description,
        ]);

        $users = Account::all();
        foreach ($users as $user) {
            $user->notifications()->attach($notification->id, ['read' => false]);
        }

        return $notification;
    }
}