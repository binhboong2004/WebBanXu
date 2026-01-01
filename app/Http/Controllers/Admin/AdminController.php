<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function home()
    {
        $user = Auth::user(); // Lấy thông tin admin đang đăng nhập

        // 1. Thống kê số lượng tổng cho các Stat-Cards
        $totalOrders = DB::table('orders')->count(); // Tổng đơn hàng
        $totalUsers = DB::table('users')->count(); // Tổng thành viên
        $totalProducts = DB::table('accounts')->count(); // Tổng tài sản/sản phẩm

        // 2. Lấy 5 giao dịch dòng tiền gần nhất (Nạp tiền & Mua hàng)
        $inflow = DB::table('recharge_history')
            ->join('users', 'recharge_history.user_id', '=', 'users.id')
            ->select('users.username', 'recharge_history.amount', 'recharge_history.transaction_note as note', 'recharge_history.created_at', DB::raw("'in' as type"));

        $outflow = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('users.username', 'orders.total_price as amount', DB::raw("CONCAT('Mua đơn hàng #', orders.order_number) as note"), 'orders.created_at', DB::raw("'out' as type"));

        $recentFlows = $inflow->union($outflow)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(); // Lấy 5 bản ghi mới nhất

        // 3. Chuẩn bị dữ liệu biểu đồ cho 10 ngày gần đây
        $chartData = ['labels' => [], 'orders' => [], 'users' => []];
        for ($i = 9; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartData['labels'][] = now()->subDays($i)->format('d/m');
            $chartData['orders'][] = DB::table('orders')->whereDate('created_at', $date)->count();
            $chartData['users'][] = DB::table('users')->whereDate('created_at', $date)->count();
        }

        return view('admin.pages.dashboard', compact('user', 'totalOrders', 'totalUsers', 'totalProducts', 'recentFlows', 'chartData'));
    }
}