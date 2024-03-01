<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;

class NotificationRead extends Model
{
    use HasFactory;

    protected $table = 'notification_reads';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'notification_id',
        'read',
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id', 'id');
    }
}
