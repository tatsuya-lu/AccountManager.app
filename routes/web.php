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
    Route::get('/account', [\App\Http\Controllers\AccountController::class, 'adminTable'])->name('account');

    // アカウント編集フォーム表示
    Route::get('/account/{user}/edit', [\App\Http\Controllers\AccountController::class, 'edit'])->name('account.edit');

    // アカウント編集処理
    Route::put('/account/{user}', [\App\Http\Controllers\AccountController::class, 'update'])->name('account.update');

    // アカウント削除処理
    Route::delete('/account/{user}', [\App\Http\Controllers\AccountController::class, 'destroy'])->name('account.destroy');

    Route::get('/account/register', [\App\Http\Controllers\AccountController::class, 'adminRegisterForm'])->name('account.register.form');
    Route::post('/account/register', [\App\Http\Controllers\AccountController::class, 'adminRegister'])->name('account.register');

    // お問い合わせ一覧表示
    Route::get('/inquiry', [\App\Http\Controllers\InquiryController::class, 'index'])->name('inquiry.index');

    // お問い合わせ編集フォーム表示
    Route::get('/inquiry/{inquiry}/edit', [\App\Http\Controllers\InquiryController::class, 'edit'])->name('inquiry.edit');

    // お問い合わせ編集処理
    Route::put('/inquiry/{inquiry}', [\App\Http\Controllers\InquiryController::class, 'update'])->name('inquiry.update');

    // お問い合わせ削除処理
    Route::delete('/inquiry/{inquiry}', [\App\Http\Controllers\InquiryController::class, 'destroy'])->name('inquiry.destroy');
});


//入力フォームページ
Route::get('/contact', [\App\Http\Controllers\ContactsController::class, 'index'])->name('contact.index');
//確認フォームページ
Route::post('/contact/confirm', [\App\Http\Controllers\ContactsController::class, 'confirm'])->name('contact.confirm');
//送信完了フォームページ
Route::post('/contact/thanks', [\App\Http\Controllers\ContactsController::class, 'send'])->name('contact.send');
