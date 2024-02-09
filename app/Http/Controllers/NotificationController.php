<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\NotificationRead;

class NotificationController extends Controller
{
    /**
     * お知らせ一覧を表示する。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('notification.index');
    }

    /**
     * お知らせ詳細を表示し、既読フラグを更新する。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \App\Models\Notification
     */
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

        return $notification;
    }

    /**
     * ユーザーに関連する未読のお知らせをリストする。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
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

    public function showAllNotifications()
    {
        // すべてのお知らせを取得して返す
        $notifications = Notification::orderBy('created_at', 'desc')->get();

        return response()->json($notifications);
    }
}
