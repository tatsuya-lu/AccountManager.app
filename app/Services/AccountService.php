<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class AccountService
{
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

    public function delete(Account $user)
    {
        $user->delete();
    }
}
