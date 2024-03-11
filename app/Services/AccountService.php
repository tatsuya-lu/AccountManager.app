<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class AccountService
{

    public function accountList($request)
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

        return $users;
    }

    public function register(array $data)
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
            'comment' => $data['comment'] ?? '',
            'admin_level' => intval($data['admin_level']),
        ]);

        return $user;
    }

    public function update(Account $user, array $data)
    {
        $user->name = $data['name'];
        $user->sub_name = $data['sub_name'];
        $user->email = $data['email'];
        $user->tel = $data['tel'];
        $user->prefecture = $data['prefecture'];
        $user->post_code = $data['post_code'];
        $user->city = $data['city'];
        $user->street = $data['street'];
        $user->comment = $data['comment'] ?? '';
        $user->admin_level = intval($data['admin_level']);

        if (isset($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        $user->save();

        return $user;
    }

    public function destroy(Account $user)
    {
        $user->delete();
    }
}
