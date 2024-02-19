<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account\Notification;
use App\Models\Account\NotificationRead;

class NotificationController extends Controller
{

    public function show(Request $request, Notification $notification)
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        $notificationRead = NotificationRead::where('user_id', $user->id)
            ->where('notification_id', $notification->id)
            ->first();

        if ($notificationRead) {
            $notificationRead->read = true;
            $notificationRead->save();
        }

        return view('account.Notification',compact('notification'));
    }

    public function list(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        return Notification::whereHas('reads', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('read', false);
        })
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(7);
    }
}
