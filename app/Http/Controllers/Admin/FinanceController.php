<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    /**
     * Hiển thị form nạp tiền
     */
    public function add_funds(Request $request)
    {
        $user = Auth::user();
        $target_user_id = $request->query('user_id');

        return view('admin.pages.add_funds', compact('user', 'target_user_id'));
    }

    /**
     * Xử lý cộng tiền và ghi lịch sử
     */
    public function process_add_funds(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount'  => 'required|numeric|min:1000',
            'method'  => 'required|string', // Ô input tên là "method"
        ], [
            'user_id.exists' => 'ID người dùng không tồn tại!',
            'amount.min'     => 'Số tiền nạp tối thiểu là 1,000đ!',
        ]);

        $customer = User::findOrFail($request->user_id);

        try {
            DB::transaction(function () use ($customer, $request) {

                // Cập nhật số dư User
                $customer->balance += $request->amount;
                $customer->total_recharge += $request->amount;
                $customer->save();

                // LẤY DỮ LIỆU QUA HÀM input() ĐỂ TRÁNH LỖI PROTECTED
                $paymentMethod = $request->input('method');
                $note = $request->input('note') ?? 'Admin cộng tiền hệ thống';

                // Ghi vào lịch sử nạp
                DB::table('recharge_history')->insert([
                    'user_id'          => $customer->id,
                    'amount'           => $request->amount,
                    'method'           => $paymentMethod, // Đã sửa ở đây
                    'transaction_note' => $note,
                    'status'           => 1,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            });

            return back()->with('success', "Nạp thành công " . number_format($request->amount) . "đ cho " . $customer->username);
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    public function cashflow()
    {
        $admin = Auth::user();

        // 1. Lấy dòng tiền vào (Nạp tiền)
        $inflow = DB::table('recharge_history')
            ->join('users', 'recharge_history.user_id', '=', 'users.id')
            ->select(
                'recharge_history.id',
                'users.username',
                'recharge_history.amount',
                'recharge_history.transaction_note as note',
                'recharge_history.created_at',
                DB::raw("'in' as type") // Đánh dấu là tiền vào
            );

        // 2. Lấy dòng tiền ra (Mua hàng)
        $outflow = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.id',
                'users.username',
                'orders.total_price as amount',
                DB::raw("CONCAT('Mua đơn hàng #', orders.order_number) as note"),
                'orders.created_at',
                DB::raw("'out' as type") // Đánh dấu là tiền ra
            );

        // 3. Gộp lại và phân trang
        $cashflows = $inflow->union($outflow)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // 4. Tính tổng thu/chi để hiển thị lên Badge
        $totalIn = DB::table('recharge_history')->sum('amount');
        $totalOut = DB::table('orders')->sum('total_price');

        return view('admin.pages.cashflow', compact('admin', 'cashflows', 'totalIn', 'totalOut'));
    }
}
