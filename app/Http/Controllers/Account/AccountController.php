<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Account\Account;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Account\AccountRequest;
use App\Models\Account\Notification;
use App\Models\Account\NotificationRead;

class AccountController extends Controller
{
    use RegistersUsers;

    protected $prefectures;
    protected $adminLevels;

    public function __construct()
    {
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

    protected function registerDatabase(array $data)
    {
        $user = Account::create([
            'name' => $data['name'],
            'sub_name' => $data['sub_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'tel' => $data['tel'],
            'post_code' => $data['post_code'],
            'prefecture' => $data['prefecture'],
            'city' => $data['city'],
            'street' => $data['street'],
            'comment' => $data['comment'] !== null ? $data['comment'] : '',
            'admin_level' => intval($data['admin_level']),
        ]);

        if ($user) {
            session()->flash('registered_message', 'アカウントが正常に登録されました。');
        }

        return $user;
    }

    public function register(AccountRequest $request)
    {
        $user = $this->registerDatabase($request->all());

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
        $user->name = $request->name;
        $user->email = $request->email;
        $user->tel = $request->tel;
        $user->prefecture = $request->prefecture;
        $user->post_code = $request->post_code;
        $user->city = $request->city;
        $user->street = $request->street;
        $user->comment = $request->comment;
        $user->admin_level = $request->admin_level;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

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
        $user->delete();
        return redirect()->route('account.list')->with('success', 'ユーザーが正常に削除されました。');
    }
}
