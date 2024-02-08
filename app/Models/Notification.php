<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $appends = ['url', 'date'];

    // Relationship
    public function reads()
    {

        return $this->hasMany(NotificationRead::class, 'notification_id', 'id');
    }

    // Accessor
    public function getUrlAttribute()
    {

        return route('notification.show', $this->id);
    }

    public function getDateAttribute()
    {

        return $this->created_at->format('m月d日');
    }
}
