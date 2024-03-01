<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;
use Illuminate\Notifications\Notifiable;


class Account extends Model implements Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'accounts';

    protected $fillable = [
        'name',
        'sub_name',
        'email',
        'password',
        'tel',
        'post_code',
        'prefecture',
        'city',
        'street',
        'comment',
        'admin_level',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function deleteBookById($id)
    {
        return $this->destroy($id);
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; 
    }

    public function createNotification($data)
    {
        return Notification::create($data);
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_reads', 'user_id', 'notification_id')
            ->withPivot('read')
            ->withTimestamps();
    }
}
