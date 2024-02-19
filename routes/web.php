<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\LoginController;
use App\Http\Controllers\Account\InquiryController;
use App\Http\Controllers\Account\NotificationController;
use App\Http\Controllers\Contact\ContactsController;
use App\Http\Controllers\Controller;
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
    return view('account.Login');
})->middleware('guest:admin');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/dashboard', [AccountController::class, 'index'])
    ->middleware('auth:admin')
    ->name('dashboard');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('account')->middleware(['auth:admin'])->group(function () {
    // 既存のアカウント一覧表示
    Route::get('/list', [AccountController::class, 'accountList'])->name('account.list');

    // アカウント編集フォーム表示
    Route::get('/{user}/edit', [AccountController::class, 'edit'])->name('account.edit')->middleware('account.authorization');

    // アカウント編集処理
    Route::put('/{user}', [AccountController::class, 'update'])->name('account.update')->middleware('account.authorization');

    // アカウント削除処理
    Route::delete('/{user}', [AccountController::class, 'destroy'])->name('account.destroy')->middleware('account.authorization');

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

    Route::get('/notification/list', [NotificationController::class, 'list'])->name('notification.list');

    Route::get('/notification/{notification}', [NotificationController::class, 'show'])->name('notification.show');
});

Route::prefix('contact')->group(function () {
    //入力フォームページ
    Route::get('/', [ContactsController::class, 'index'])->name('contact.index');
    //確認フォームページ
    Route::post('/confirm', [ContactsController::class, 'confirm'])->name('contact.confirm');
    //送信完了フォームページ
    Route::post('/thanks', [ContactsController::class, 'send'])->name('contact.send');
});
