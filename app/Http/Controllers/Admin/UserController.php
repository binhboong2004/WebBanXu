<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function user_list()
    {
        // 1. Lấy thông tin admin đang đăng nhập để hiển thị trên top-header
        $admin = Auth::user();
        if (!$admin) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập!');
        }
        $users = User::orderBy('id', 'desc')->paginate(12);

        // 3. Trả về view và truyền biến admin và users
        return view('admin.pages.user_list', [
            'user' => $admin, // Biến $user dùng cho header trong code của bạn
            'users' => $users // Danh sách tất cả người dùng để lặp
        ]);
    }
    public function delete_user($id)
    {
        // Tìm người dùng theo ID
        $user = User::find($id);

        if ($user) {
            // Không cho phép xóa chính mình (admin đang đăng nhập)
            if ($user->id == auth()->id()) {
                return back()->with('error', 'Bạn không thể tự xóa chính mình!');
            }

            $user->delete();
            return back()->with('success', 'Đã xóa người dùng thành công!');
        }

        return back()->with('error', 'Không tìm thấy người dùng!');
    }

    public function set_admin($id)
    {
        $user = User::find($id);

        if ($user) {
            // Cập nhật role thành admin
            $user->update(['role' => 'admin']);

            return back()->with('success', "Đã cấp quyền Admin cho tài khoản {$user->username} thành công!");
        }

        return back()->with('error', 'Không tìm thấy người dùng!');
    }
}
