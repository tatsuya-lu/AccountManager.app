<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationRead;
use App\Models\Account;

class NotificationService
{
    public function store($title, $description)
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

    public function getNotificationsForDashboard()
    {
        $user = auth()->user();
        $readNotificationIds = NotificationRead::where('user_id', $user->id)
            ->where('read', true)
            ->pluck('notification_id')
            ->toArray();

        $notifications = Notification::orderBy('id', 'desc')
            ->paginate(5, ['*'], 'dashboard_page');

        return [
            'readNotificationIds' => $readNotificationIds,
            'notifications' => $notifications,
        ];
    }
}