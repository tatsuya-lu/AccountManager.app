<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests\Account\AccountRequest;
use App\Models\Account;
use App\Services\AccountService;
use App\Services\InquiryService;
use App\Services\NotificationService;

class AccountController extends Controller
{
    use RegistersUsers;

    protected $prefectures;
    protected $adminLevels;
    protected $accountService;
    protected $inquiryService;
    protected $notificationService;

    public function __construct(AccountService $accountService, InquiryService $inquiryService, NotificationService $notificationService)
    {
        $this->prefectures = config('const.prefecture');
        $this->adminLevels = config('const.admin_level');
        $this->accountService = $accountService;
        $this->inquiryService = $inquiryService; 
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $notificationData = $this->notificationService->getNotificationsForDashboard();
        $unresolvedInquiryCount = $this->inquiryService->unresolvedInquiryCount();
        $unresolvedInquiries = $this->inquiryService->unresolvedInquiries();

        return view('account.Dashboard', compact('notificationData', 'unresolvedInquiryCount', 'unresolvedInquiries'));
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

    public function accountList()
    {
        $users = $this->accountService->accountList();

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
        $this->accountService->destroy($user);

        return redirect()->route('account.list')->with('success', 'ユーザーが正常に削除されました。');
    }
}
