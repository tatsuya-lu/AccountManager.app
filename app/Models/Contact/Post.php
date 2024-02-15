<?php

namespace App\Models\Contact;

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
