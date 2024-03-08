<?php

namespace App\Services;

use App\Models\Post;

class ContactService
{
    public function store(array $data)
    {
        return Post::create([
            'company' => $data['company'],
            'name' => $data['name'],
            'tel' => $data['tel'],
            'email' => $data['email'],
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'profession' => $data['profession'],
            'body' => $data['body']
        ]);
    }
}