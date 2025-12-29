<?php

use App\Http\Controllers\Clients\AccountController;
use App\Http\Controllers\Clients\AuthController;
use App\Http\Controllers\Clients\ForgotPasswordController;
use App\Http\Controllers\Clients\ProfileController;
use App\Http\Controllers\Clients\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProfileController::class, 'home'])->name('home');

Route::get('/mua_tai_khoan', [ProfileController::class, 'mua_tai_khoan'])->name('mua_tai_khoan');

Route::get('/cong_cu', [ProfileController::class, 'cong_cu'])->name('cong_cu');

Route::get('/huong_dan', [ProfileController::class, 'huong_dan'])->name('huong_dan');

Route::get('/404', function () {
    return view('clients.pages.404');
});

Route::get('/lien_he', [ProfileController::class, 'lien_he'])->name('lien_he');
//guest

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('post-register');
    Route::get('/login', [AuthController::class, 'showloginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('post-login');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

    Route::get('/resset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/resset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::get('/activate/{token}', [AuthController::class, 'activate'])->name('activate');


Route::middleware(['auth.custom'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
        
    });
    Route::get('/change_password', [ProfileController::class, 'showChangePassword'])->name('password.change');
    Route::get('/lich_su_mua', [ProfileController::class, 'lich_su_mua'])->name('lich_su_mua');
    Route::get('/nap_ngan_hang', [ProfileController::class, 'nap_ngan_hang'])->name('nap_ngan_hang');
    Route::get('/nap_momo', [ProfileController::class, 'nap_momo'])->name('nap_momo');
});
