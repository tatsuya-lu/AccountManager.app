<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
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

    public function show(Notification $notification)
    {
        $user = Auth::user();

        if (!$user) {
            return null; 
        }
        
        $this->markNotificationAsRead($user, $notification);
        return $notification;
    }

    private function markNotificationAsRead($user, $notification)
    {
        $notificationRead = NotificationRead::where('user_id', $user->id)
            ->where('notification_id', $notification->id)
            ->first();

        if ($notificationRead) {
            $notificationRead->read = true;
            $notificationRead->save();
        }
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
