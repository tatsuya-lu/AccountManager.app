<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Account extends Model implements Authenticatable
{
    use HasFactory;

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
        'body',
        'isAdmin',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'isAdmin' => 'boolean',
    ];

    public function deleteBookById($id)
    {
        return $this->destroy($id);
    }

    public function getAuthIdentifierName() {
        return 'id';
    }

    public function getAuthIdentifier() {
        return $this->getKey();
    }

    public function getAuthPassword() {
        return $this->password;
    }

    public function getRememberToken() {
        return $this->remember_token; // ユーザーの"remember_token"を取得します
    }

    public function setRememberToken($value) {
        $this->remember_token = $value; // ユーザーの"remember_token"を設定します
    }

    public function getRememberTokenName() {
        return 'remember_token'; // "remember_token" カラム名を指定します
    }
}
