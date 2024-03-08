<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests\Account\AccountRequest;
use App\Models\Account;
use App\Models\Notification;
use App\Models\NotificationRead;
use App\Services\AccountService;

class AccountController extends Controller
{
    use RegistersUsers;

    protected $prefectures;
    protected $adminLevels;
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
        $this->prefectures = config('const.prefecture');
        $this->adminLevels = config('const.admin_level');
    }

    public function index(Request $request, InquiryController $inquiryController)
    {
        $user = auth()->user();
        $readNotificationIds = NotificationRead::where('user_id', $user->id)
            ->where('read', true)
            ->pluck('notification_id')
            ->toArray();

        $notifications = Notification::orderBy('id', 'desc')
            ->paginate(5, ['*'], 'dashboard_page');
        $unresolvedInquiryCount = $inquiryController->unresolvedInquiryCount();
        $unresolvedInquiries = $inquiryController->unresolvedInquiries('inquiry_page');

        return view('account.Dashboard', compact('notifications', 'readNotificationIds', 'unresolvedInquiryCount', 'unresolvedInquiries'));
    }

    public function registerForm(Request $request)
    {
        $user = new Account;
        $prefectures = $this->prefectures;
        $adminLevels = $this->adminLevels;

        return view('account.Register', compact('user', 'prefectures', 'adminLevels'));
    }

    public function register(AccountRequest $request)
    {
        $user = $this->accountService->register($request->all());

        if ($user) {
            session()->flash('registered_message', 'アカウントが正常に登録されました。');
            session()->flash('registered_email', $user->email);
            return redirect()->route('account.list');
        } else {
            return redirect()->route('account.list')->with('error', 'ユーザーの登録に失敗しました。');
        }
    }

    public function accountList(Request $request)
    {
        $sort = $request->input('sort', 'newest');

        $query = Account::query();

        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $users = $query->where(function ($query) use ($request) {
            if ($searchName = $request->input('search_name')) {
                $query->where('name', 'LIKE', '%' . $searchName . '%');
            }

            if ($searchAdminLevel = $request->input('search_admin_level')) {
                $adminLevelValue = is_numeric($searchAdminLevel) ? $searchAdminLevel : ($searchAdminLevel == '社員' ? 1 : ($searchAdminLevel == '管理者' ? 2 : null));
                if ($adminLevelValue !== null) {
                    $query->where('admin_level', $adminLevelValue);
                }
            }

            if ($searchEmail = $request->input('search_email')) {
                $query->where('email', 'LIKE', '%' . $searchEmail . '%');
            }
        })->paginate(20);

        foreach ($users as $user) {
            $user->prefecture = config('const.prefecture.' . $user->prefecture);
            $user->admin_level = $user->admin_level == 1 ? '管理者' : ($user->admin_level == 2 ? '社員' : '');
        }

        return view('account.AccountList', compact('users'));
    }

    public function update(AccountRequest $request, Account $user)
    {
        $this->accountService->update($user, $request->all());

        return redirect()->route('account.list')->with('success', 'ユーザーが正常に更新されました。');
    }

    public function edit(Account $user)
    {
        $prefectures = $this->prefectures;
        $adminLevels = $this->adminLevels;

        return view('account.Register', compact('user', 'prefectures', 'adminLevels'));
    }

    public function destroy(Account $user)
    {
        $this->accountService->delete($user);

        return redirect()->route('account.list')->with('success', 'ユーザーが正常に削除されました。');
    }
}
