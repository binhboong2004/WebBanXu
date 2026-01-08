<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (Auth::check()) {
            // Kiểm tra cột role trong database có phải là 'admin' không
            if (Auth::user()->role === 'admin') {
                return $next($request);
            }
        }

        // Nếu không phải admin, chuyển hướng về trang chủ kèm thông báo lỗi
        return redirect('/')->with('error', 'Bạn không có quyền truy cập vào trang quản trị!');
    }
}