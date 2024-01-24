<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';

Route::get('/login', function () {
    return view('account.Login'); // blade.php
})->middleware('guest:admin');

Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');

Route::get('/dashboard', function () {
    return view('account.Dashboard');
})->middleware('auth:admin');

Route::get('/logout',[\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    // 既存のアカウント一覧表示
    Route::get('/table', [AccountController::class, 'adminTable'])->name('admin.table');

    // アカウント編集フォーム表示
    Route::get('/table/{user}/edit', [AccountController::class, 'edit'])->name('admin.table.edit');

    // アカウント編集処理
    Route::put('/table/{user}', [AccountController::class, 'update'])->name('admin.table.update');

    // アカウント削除処理
    Route::delete('/table/{user}', [AccountController::class, 'destroy'])->name('admin.table.destroy');

    Route::get('/table/register', [AccountController::class, 'adminRegisterForm'])->name('admin.table.register.form');
    Route::post('/table/register', [AccountController::class, 'adminRegister'])->name('admin.table.register');

    // お問い合わせ一覧表示
    Route::get('/inquiry', [InquiryController::class, 'index'])->name('admin.inquiry.index');

    // お問い合わせ編集フォーム表示
    Route::get('/inquiry/{inquiry}/edit', [InquiryController::class, 'edit'])->name('admin.inquiry.edit');

    // お問い合わせ編集処理
    Route::put('/inquiry/{inquiry}', [InquiryController::class, 'update'])->name('admin.inquiry.update');

    // お問い合わせ削除処理
    Route::delete('/inquiry/{inquiry}', [InquiryController::class, 'destroy'])->name('admin.inquiry.destroy');
});


//入力フォームページ
Route::get('/contact', [\App\Http\Controllers\ContactsController::class, 'index'])->name('contact.index');
//確認フォームページ
Route::post('/contact/confirm', [\App\Http\Controllers\ContactsController::class, 'confirm'])->name('contact.confirm');
//送信完了フォームページ
Route::post('/contact/thanks', [\App\Http\Controllers\ContactsController::class, 'send'])->name('contact.send');
