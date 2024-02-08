<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Notification;
use App\Models\NotificationRead;
use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ユーザーIDを取得
        $userIds = Account::orderBy('id')->pluck('id');

        // 25個のお知らせを作成
        for ($i = 0; $i < 25; $i++) {
            $notification = Notification::create([
                'title' => 'テストタイトル - ' . $i,
                'description' => "テストお知らせ\nテストお知らせ\nテストお知らせ - " . $i,
            ]);

            // 各ユーザーにお知らせを未読として追加
            foreach ($userIds as $userId) {
                NotificationRead::create([
                    'user_id' => $userId,
                    'notification_id' => $notification->id,
                    'read' => false, // 未読
                ]);
            }
        }
    }
}
