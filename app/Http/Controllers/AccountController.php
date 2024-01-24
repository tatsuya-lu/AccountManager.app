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
    protected $isAdmin;

    protected function __construct()
    {
        $this->prefectures = config('const.prefecture');
        $this->isAdmin = config('const.isAdmin');

        view()->share(['prefecture' => $this->prefectures, 'isAdmin' => $this->isAdmin]);
    }

    public function registerForm(Request $request)
    {
        $user = new Account;
        $prefectures = $this->prefectures;
        $isAdmin = $this->isAdmin;

        return view('account.Register',compact('user', 'prefectures', 'isAdmin'));
    }

    protected function adminRegisterDatabase(array $data)
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
            'body' => $data['body'] !== null ? $data['body'] : '',
            'isAdmin' => intval($data['isAdmin']),
        ]);

        if ($user) {
            session()->flash('registered_message', 'アカウントが正常に登録されました。');
        }

        return $user;
    }

    public function adminRegister(AccountRequest $request)
    {
        $user = $this->adminRegisterDatabase($request->all());

        if ($user) {
            session()->flash('registered_message', 'アカウントが正常に登録されました。');
            session()->flash('registered_email', $user->email);
            return redirect()->route('account');
        } else {
            return redirect()->route('account')->with('error', 'ユーザーの登録に失敗しました。');
        }
    }

    public function adminTable(Request $request)
    {

        $users = Account::orderBy('created_at', 'asc')->where(function ($query) use ($request) {
            if ($searchName = $request->input('search_name')) {
                $query->where('name', 'LIKE', '%' . $searchName . '%');
            }

            if ($searchisAdmin = $request->input('search_isAdmin')) {
                $isAdminValue = is_numeric($searchisAdmin) ? $searchisAdmin : ($searchisAdmin == '社員' ? 'off' : ($searchisAdmin == '管理者' ? 'on' : null));
                if ($isAdminValue !== null) {
                    $query->where('admin_level', $isAdminValue);
                }
            }

            if ($searchEmail = $request->input('search_email')) {
                $query->where('email', 'LIKE', '%' . $searchEmail . '%');
            }
        })->paginate(20);

        return view('adminTable', compact('users'));
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
        $user->body = $request->body;
        $user->isAdmin = $request->isAdmin;


        if ($request->filled('password')) {
            // パスワードのハッシュ化
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('table')->with('success', 'ユーザーが正常に更新されました。');
    }

    public function edit(Account $user)
    {
        $prefectures = $this->prefectures;
        $isAdmin = $this->isAdmin;

        return view('account.Register', compact('user', 'prefectures', 'isAdmin'));
    }

    public function destroy(Account $user)
    {

        // ユーザー削除
        $user->delete();

        // 削除後にリダイレクト
        return redirect()->route('table')->with('success', 'ユーザーが正常に削除されました。');
    }

}
