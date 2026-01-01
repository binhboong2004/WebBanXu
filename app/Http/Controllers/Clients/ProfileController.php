<?php
// app/Http/Controllers/Clients/ProfileController.php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        // Lấy toàn bộ thông tin tài khoản đang đăng nhập từ MySQL
        $user = Auth::user();

        // Truyền biến $user sang view profile.blade.php
        return view('clients.pages.profile', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($request->hasFile('avatar')) {
            //Delete old photo
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $file = $request->file('avatar');
            //Create new name with timestamp
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalExtension();

            //Save img to folder
            $avatarPath = $file->storeAs('uploads/users', $filename, 'public');
            $user->avatar = $avatarPath;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thông tin thành công',
                'avatar' => asset('storage/' . $user->avatar)
            ]);
        }
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải từ 6 ký tự.',
            'confirm_password.same' => 'Xác nhận mật khẩu không khớp.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Kiểm tra mật khẩu hiện tại có khớp với DB không
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu hiện tại không chính xác.'
            ], 422);
        }

        // 2. Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save(); // Lưu vào database

        return response()->json([
            'success' => true,
            'message' => 'Thay đổi mật khẩu thành công!'
        ]);
    }

    public function showChangePassword()
    {
        $user = Auth::user();
        return view('clients.pages.change_password', compact('user'));
    }

    public function home()
    {
        $user = Auth::user();
        // Lấy các tài khoản đang bán (status = 0), gộp nhóm theo loại và số xu
        $accountGroups = Account::where('status', 0)
            ->select('category_id', 'xu_amount', 'price', DB::raw('count(*) as total'))
            ->groupBy('category_id', 'xu_amount', 'price')
            ->with('category') // Để lấy tên loại như Traodoisub, TTC
            ->get();

        // 2. Lấy 10 đơn hàng mới nhất trên toàn hệ thống
        $recentOrders = \App\Models\Order::with(['user', 'account.category'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // 3. Lấy 10 giao dịch nạp tiền mới nhất trên toàn hệ thống
        $recentRecharges = \App\Models\RechargeHistory::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        return view('clients.pages.home', compact('user', 'accountGroups', 'recentOrders', 'recentRecharges'));
    }

    public function mua_tai_khoan()
    {
        $user = Auth::user();
        $categories = Category::all();
        $accountGroups = Account::where('status', 0)
            ->select('category_id', 'xu_amount', 'price', DB::raw('count(*) as total'))
            ->groupBy('category_id', 'xu_amount', 'price')
            ->with('category') // Lấy thông tin category để hiển thị tên (Traodoisub, TTC...)
            ->get();
        return view('clients.pages.mua_tai_khoan', compact('user', 'categories', 'accountGroups'));
    }

    public function lich_su_mua()
    {
        $user = Auth::user();
        $orders = \App\Models\Order::where('user_id', $user->id)
            ->with(['account.category']) // Load kèm thông tin tài khoản và danh mục
            ->orderBy('created_at', 'desc') // Đơn hàng mới nhất lên đầu
            ->get();
        return view('clients.pages.lich_su_mua', compact('user', 'orders'));
    }

    public function nap_ngan_hang()
    {
        $user = Auth::user();
        return view('clients.pages.nap_ngan_hang', compact('user'));
    }
    public function nap_momo()
    {
        $user = Auth::user();
        return view('clients.pages.nap_momo', compact('user'));
    }

    public function lien_he()
    {
        $user = Auth::user();
        return view('clients.pages.lien_he', compact('user'));
    }

    public function cong_cu()
    {
        $user = Auth::user();
        return view('clients.pages.cong_cu', compact('user'));
    }

    public function huong_dan()
    {
        $user = Auth::user();
        return view('clients.pages.huong_dan', compact('user'));
    }

    public function processBuy(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $categoryId = $request->category_id;
        $xuAmount = $request->xu_amount;
        $quantity = (int)$request->quantity;

        // 1. Kiểm tra tài khoản còn trong kho không (status = 0 là chưa bán)
        $accounts = Account::where('category_id', $categoryId)
            ->where('xu_amount', $xuAmount)
            ->where('status', 0)
            ->limit($quantity)
            ->get();

        if ($accounts->count() < $quantity) {
            return response()->json(['success' => false, 'message' => 'Số lượng tài khoản trong kho không đủ!']);
        }

        // 2. Tính toán tổng tiền
        $pricePerAcc = $accounts->first()->price;
        $totalPrice = $pricePerAcc * $quantity;

        if ($user->balance < $totalPrice) {
            return response()->json(['success' => false, 'message' => 'Số dư không đủ. Vui lòng nạp thêm!']);
        }

        try {
            // 3. Thực hiện giao dịch
            DB::transaction(function () use ($user, $accounts, $totalPrice) {
                // Trừ tiền người dùng
                $user->decrement('balance', $totalPrice);

                foreach ($accounts as $acc) {
                    // Cập nhật trạng thái tài khoản đã bán
                    $acc->update(['status' => 1]);

                    // Tạo đơn hàng
                    Order::create([
                        'user_id' => $user->id,
                        'account_id' => $acc->id,
                        'total_price' => $acc->price,
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Mua thành công ' . $quantity . ' tài khoản!',
                'new_balance' => number_format($user->balance) . 'đ'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
        }
    }

    public function lich_su_nap()
    {
        $user = Auth::user();

        // Lấy lịch sử nạp của user hiện tại, sắp xếp mới nhất lên đầu
        $recharges = \App\Models\RechargeHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('clients.pages.lich_su_nap', compact('user', 'recharges'));
    }
}
