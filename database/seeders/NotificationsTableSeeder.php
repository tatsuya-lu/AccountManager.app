<?php

namespace Database\Seeders;

use App\Models\Account\Account;
use App\Models\Account\Notification;
use App\Models\Account\NotificationRead;
use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = Account::orderBy('id')->pluck('id');

        for ($i = 0; $i < 25; $i++) {
            $notification = Notification::create([
                'title' => 'テストタイトル - ' . $i,
                'description' => "テストお知らせ\nテストお知らせ\nテストお知らせ - " . $i,
            ]);

            foreach ($userIds as $userId) {
                NotificationRead::create([
                    'user_id' => $userId,
                    'notification_id' => $notification->id,
                    'read' => false,
                ]);
            }
        }
    }
}
