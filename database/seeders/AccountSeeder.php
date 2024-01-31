<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::create([
            'name' => '山田太郎',
            'sub_name' => 'ヤマダタロウ',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
            'tel' => '01234567890',
            'post_code' => '0123456',
            'prefecture' => '東京都',
            'city' => '港区',
            'street' => '芝公園',
            'comment' => 'これは備考欄です。',
            'admin_level' => 'on',
        ]);
    }
}
