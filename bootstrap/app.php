<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Đăng ký Alias để Laravel hiểu các tên gọi trong web.php
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'auth.custom' => \App\Http\Middleware\RedirectIfNotAuthenticated::class, // Sử dụng class Auth mặc định hoặc class riêng của bạn
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();