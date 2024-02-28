<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account\Account;
use Illuminate\Http\Request;
use App\Http\Requests\Account\NotificationRequest;
use App\Models\Account\Notification;
use App\Models\Account\NotificationRead;

class NotificationController extends Controller
{

    public function show(Request $request, Notification $notification)
    {
        $user = $request->user();

        if (!$user) {
            abort(403, '権限がないためこの操作を実行できません。');
        }

        $notificationRead = NotificationRead::where('user_id', $user->id)
            ->where('notification_id', $notification->id)
            ->first();

        if ($notificationRead) {
            $notificationRead->read = true;
            $notificationRead->save();
        }

        return view('account.Notification', compact('notification'));
    }

    public function list(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            abort(403, '権限がないためこの操作を実行できません。');
        }

        return Notification::whereHas('reads', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('read', false);
        })
            ->orderBy('id', 'desc')
            ->paginate(7);
    }

    public function create()
    {
        return view('account.NotificationRegister');
    }

    public function store(NotificationRequest $request)
    {
        $notification = new Notification();
        $notification->title = $request->title;
        $notification->description = $request->description;
        $notification->save();

        $users = Account::all();
        foreach ($users as $user) {
            $user->notifications()->attach($notification->id, ['read' => false]);
        }

        return redirect()->route('dashboard')->with('success', 'お知らせが作成されました。');
    }
}
