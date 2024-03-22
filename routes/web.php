<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\LoginController;
use App\Http\Controllers\Account\InquiryController;
use App\Http\Controllers\Account\NotificationController;
use App\Http\Controllers\Contact\ContactsController;
use Illuminate\Support\Facades\Route;


//ログイン処理
Route::get('/', [LoginController::class, 'show'])->middleware('guest:admin');
Route::post('/', [LoginController::class, 'login'])->name('login');

//ログアウト処理
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('account')->middleware(['auth:admin'])->group(function () {

    //ダッシュボードの表示
    Route::get('/dashboard', [AccountController::class, 'index'])->name('dashboard');

    // 既存のアカウント一覧表示
    Route::get('/list', [AccountController::class, 'accountList'])->name('account.list');

    // アカウント編集フォーム表示
    Route::get('/{user}/edit', [AccountController::class, 'edit'])->name('account.edit')->middleware('account.authorization');

    // アカウント編集処理
    Route::put('/{user}', [AccountController::class, 'update'])->name('account.update')->middleware('account.authorization');

    // アカウント削除処理
    Route::delete('/{user}', [AccountController::class, 'destroy'])->name('account.destroy')->middleware('account.authorization');

    //アカウント登録処理
    Route::get('/register', [AccountController::class, 'registerForm'])->name('account.register.form');
    Route::post('/register', [AccountController::class, 'register'])->name('account.register');

    // お問い合わせ一覧表示
    Route::get('/inquiry/list', [InquiryController::class, 'index'])->name('inquiry.list');

    // お問い合わせ編集フォーム表示
    Route::get('/inquiry/{inquiry}/edit', [InquiryController::class, 'edit'])->name('inquiry.edit');

    // お問い合わせ編集処理
    Route::put('/inquiry/{inquiry}', [InquiryController::class, 'update'])->name('inquiry.update');

    // お問い合わせ削除処理
    Route::delete('/inquiry/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiry.destroy');

    //お知らせ取得
    Route::get('/notification/list', [NotificationController::class, 'list'])->name('notification.list');

    Route::get('/notification/{notification}', [NotificationController::class, 'show'])->name('notification.show');

    //お知らせ登録処理
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notification.create')->middleware('account.authorization');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notification.store');
});

Route::prefix('contact')->group(function () {
    
    //入力フォームページ
    Route::get('/', [ContactsController::class, 'index'])->name('contact.index');

    //確認フォームページ
    Route::post('/confirm', [ContactsController::class, 'confirm'])->name('contact.confirm');

    //送信完了フォームページ
    Route::post('/thanks', [ContactsController::class, 'send'])->name('contact.send');
});
