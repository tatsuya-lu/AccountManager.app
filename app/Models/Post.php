<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'name',
        'tel',
        'email',
        'birthday',
        'gender',
        'profession',
        'body',
        'status',
        'comment',
    ];
}
