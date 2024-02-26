<?php

namespace Database\Seeders;

use App\Models\Contact\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('posts')->truncate();

        Post::factory()->count(100)->create();
    }
}
