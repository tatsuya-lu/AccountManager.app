<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AccountRequest;
use Config;

class AccountController extends Controller
{
    use RegistersUsers;

    protected $prefectures;
    protected $adminLevels;

    public function __construct()
    {
        $this->prefectures = config('const.prefecture');
        $this->adminLevels = config('const.admin_level');

        view()->share(['prefectures' => $this->prefectures, 'admin_levels' => $this->adminLevels]);
    }

    public function registerForm(Request $request)
    {
        $user = new Account;
        $prefectures = $this->prefectures;
        $adminLevels = $this->adminLevels;

        return view('account.Register',compact('user', 'prefectures', 'adminLevels'));
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
            'admin_level' => $data['admin_level'],
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

        $users = Account::orderBy('created_at', 'asc')->where(function ($query) use ($request) {
            if ($searchName = $request->input('search_name')) {
                $query->where('name', 'LIKE', '%' . $searchName . '%');
            }

            if ($searchAdminLevel = $request->input('search_admin_level')) {
                $adminLevelValue = is_numeric($searchAdminLevel) ? $searchAdminLevel : ($searchAdminLevel == '社員' ? 'off' : ($searchAdminLevel == '管理者' ? 'on' : null));
                if ($adminLevelValue !== null) {
                    $query->where('admin_level', $adminLevelValue);
                }
            }

            if ($searchEmail = $request->input('search_email')) {
                $query->where('email', 'LIKE', '%' . $searchEmail . '%');
            }
        })->paginate(20);

        return view('account.AccountList', compact('users'));
    }

    public function update(AccountRequest $request, Account $user)
    {

        // ユーザー情報の更新
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
            // パスワードのハッシュ化
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

        // ユーザー削除
        $user->delete();

        // 削除後にリダイレクト
        return redirect()->route('account.list')->with('success', 'ユーザーが正常に削除されました。');
    }

}
