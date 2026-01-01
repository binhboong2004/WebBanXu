<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orders()
    {
        $admin = \Illuminate\Support\Facades\Auth::user();

        $orders = \Illuminate\Support\Facades\DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('accounts', 'orders.account_id', '=', 'accounts.id')
            ->select(
                'orders.*', // Phải có orders.* để lấy status, order_number...
                'users.username as customer_name',
                'accounts.acc_username as product_name'
            )
            ->orderBy('orders.created_at', 'desc')
            ->get();

        return view('admin.pages.orders', compact('admin', 'orders'));
    }

    public function delete_order($id)
    {
        DB::table('orders')->where('id', $id)->delete();
        return back()->with('success', 'Đã xóa đơn hàng thành công!');
    }

    public function order_detail($id)
    {
        $admin = Auth::user();

        // Lấy thông tin chi tiết đơn hàng bằng Query Builder
        $order = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('accounts', 'orders.account_id', '=', 'accounts.id')
            ->select(
                'orders.*',
                'users.username as customer_name',
                'users.email as customer_email',
                'users.avatar as customer_avatar',
                'accounts.acc_username as product_name',
                'accounts.acc_password as product_password' // Xem pass đã bán
            )
            ->where('orders.id', $id)
            ->first();

        if (!$order) {
            return redirect()->route('admin.orders.orders')->with('error', 'Đơn hàng không tồn tại!');
        }

        return view('admin.pages.order_detail', compact('admin', 'order'));
    }
}
