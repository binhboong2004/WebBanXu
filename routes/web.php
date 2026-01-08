<?php

use App\Http\Controllers\Clients\AccountController;
use App\Http\Controllers\Clients\AuthController;
use App\Http\Controllers\Clients\ForgotPasswordController;
use App\Http\Controllers\Clients\ProfileController;
use App\Http\Controllers\Clients\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\FinanceController;

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
    Route::post('/buy-account', [ProfileController::class, 'processBuy'])->name('buy.account');
    Route::get('/lich_su_nap', [ProfileController::class, 'lich_su_nap'])->name('lich_su_nap');
});
// ROUTE ADMIN
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Trang chủ thống kê
    Route::get('/dashboard', [AdminController::class, 'home'])->name('dashboard');
    
    // Quản lý Người dùng
    Route::get('/user_list', [UserController::class, 'user_list'])->name('user_list');
    Route::delete('/user_list/delete/{id}', [UserController::class, 'delete_user'])->name('user_delete');
    Route::patch('/user_list/set-admin/{id}', [UserController::class, 'set_admin'])->name('set_admin');

    // Quản lý Danh mục
    Route::prefix('category')->name('categories.')->group(function () {
        Route::get('/list', [CategoryController::class, 'category_list'])->name('category_list');
        Route::get('/add', [CategoryController::class, 'add_category'])->name('add_category');
        Route::post('/store', [CategoryController::class, 'store_category'])->name('store');
        Route::delete('/delete/{id}', [CategoryController::class, 'delete_category'])->name('delete_category');
        Route::get('/edit/{id}', [CategoryController::class, 'edit_category'])->name('edit_category');
        Route::post('/update/{id}', [CategoryController::class, 'update_category'])->name('update_category');
    });

    // Quản lý Sản phẩm
    Route::prefix('product')->name('products.')->group(function () {
        Route::get('/list', [ProductController::class, 'product_list'])->name('product_list');
        Route::get('/add', [ProductController::class, 'add_product'])->name('add_product');
        Route::post('/store', [ProductController::class, 'store_product'])->name('store');
        Route::delete('/delete/{id}', [ProductController::class, 'delete_product'])->name('delete');
        Route::get('/edit/{id}', [ProductController::class, 'edit_product'])->name('edit');
        Route::post('/update/{id}', [ProductController::class, 'update_product'])->name('update');
    });

    // Quản lý Đơn hàng
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/list', [OrderController::class, 'orders'])->name('orders');
        Route::get('/detail/{id}', [OrderController::class, 'order_detail'])->name('order_detail');
        Route::delete('/delete/{id}', [OrderController::class, 'delete_order'])->name('delete');
    });

    // Quản lý Tài chính
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/add_funds', [FinanceController::class, 'add_funds'])->name('add_funds');
        Route::post('/add_funds', [FinanceController::class, 'process_add_funds'])->name('process_add_funds');
        Route::get('/cashflow', [FinanceController::class, 'cashflow'])->name('cashflow');
        Route::get('/receipt-detail', [FinanceController::class, 'receipt_detail'])->name('receipt_detail');
    });
});