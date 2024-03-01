<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sub_name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('tel');
            $table->string('post_code');
            $table->string('prefecture');
            $table->string('city');
            $table->string('street');
            $table->text('comment')->nullable();
            $table->integer('admin_level');
            $table->rememberToken();
            $table->timestamps();
        });

        \DB::table('accounts')->insert([
            [
                'name' => 'システム管理者',
                'sub_name' => '',
                'email' => 'owner@example.com',
                'password' => \Hash::make('password'),
                'tel' => '',
                'post_code' => '',
                'prefecture' => '',
                'city' => '',
                'street' => '',
                'comment' => '',
                'admin_level' => 1, 
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
