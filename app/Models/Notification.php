<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NotificationRead;

class Notification extends Model
{
    use HasFactory;

    protected $appends = ['url', 'date'];
    protected $fillable = ['title', 'description'];

    public function reads()
    {
        return $this->hasMany(NotificationRead::class, 'notification_id', 'id');
    }

    public function getUrlAttribute()
    {
        return route('notification.show', $this->id);
    }

    public function getDateAttribute()
    {
        return $this->created_at->format('m月d日');
    }
}
