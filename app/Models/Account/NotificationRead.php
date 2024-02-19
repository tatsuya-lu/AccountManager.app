<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Account\Notification;

class NotificationRead extends Model
{
    use HasFactory;

    // モデルと関連するテーブル
    protected $table = 'notification_reads';

    // モデルと関連するプライマリキー
    protected $primaryKey = 'id';

    // モデルのタイムスタンプを更新するかの指示
    public $timestamps = true;

    // 大量代入する属性
    protected $fillable = [
        'user_id',
        'notification_id',
        'read',
    ];

    // キャスト属性
    protected $casts = [
        'read' => 'boolean',
    ];

    // Relationship
    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id', 'id');
    }
}
