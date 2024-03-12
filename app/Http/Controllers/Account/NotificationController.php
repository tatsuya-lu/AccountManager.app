<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Account\NotificationRequest;
use App\Models\Notification;
use App\Models\NotificationRead;
use App\Services\NotificationService;

class NotificationController extends Controller
{

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function show(Request $request, Notification $notification)
    {
        $notificationData = $this->notificationService->show($notification);

        if ($notificationData === null) {
            abort(403, '権限がないためこの操作を実行できません。');
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
        $notification = $this->notificationService->store(
            $request->title,
            $request->description
        );

        return redirect()->route('dashboard')->with('success', '新しくお知らせが作成されました。');
    }
}
