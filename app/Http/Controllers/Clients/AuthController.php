<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Mail\ActivationMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegisterForm() {
        return view('clients.pages.register');
    }

    public function register(Request $request){
        //Validate backend
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ],[
            'username.requied' => 'Tên đăng nhập là bắt buộc',
            'email.requied' => 'Email là bắt buộc',
            'email.unique' => 'Email này đã được sử dụng',
            'password.requied' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Trường mật khẩu phải có ít nhất 6 ký tự',
        ]);

        //Check if email exists
        $existingUser = User::where('email', $request->email)->first();

        if($existingUser){
            return redirect()->route('register');
        }

        //Create token active
        $token = Str::random(64);
        $user = User::create([
            'username' => $request->username, // Thường website xu dùng username để đăng nhập
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'balance'  => 0,                 // Khởi tạo số dư bằng 0
            'status'   => 0,                 // 0: Chưa kích hoạt, 1: Đã kích hoạt
            'token'    => $token,            // Lưu token vào database để đối chiếu khi click mail
        ]);

        Mail::to($user->email)->send(new ActivationMail($token, $user));

        toastr()->success('Đăng ký tài khoản thành công. Vui lòng kiểm tra email của bạn để xác thực tài khoản.');
        return redirect()->route('login');
    }

    public function activate($token){
        $user = User::where('token', $token)->first();

        if($user){
            $user->status = "1";
            $user->token = null;
            $user->save();

            toastr()->success('Kích hoạt tài khoản thành công');
            return redirect()->route('login');
        }

        toastr()->error('Token không hợp lệ hoặc đã hết hạn.');
        return redirect()->route('login');
    }

    public function login(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        // 2. Thử đăng nhập
        // 'remember' giúp duy trì phiên đăng nhập nếu người dùng tích chọn
        $remember = $request->has('remember');

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $remember)) {
            
            $user = Auth::user();

            // 3. Kiểm tra trạng thái kích hoạt (status = 1)
            if ($user->status == 0) {
                Auth::logout();
                toastr()->error('Tài khoản của bạn chưa được kích hoạt. Vui lòng kiểm tra email.');
                return redirect()->back()->withInput();
            }

            // Đăng nhập thành công
            $request->session()->regenerate();
            toastr()->success('Chào mừng ' . $user->username . ' trở lại!');
            if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Thay bằng tên route trang admin của bạn
            }
            return redirect()->route('home'); // Thay 'home' bằng route trang chủ của bạn
        }
        
        // 4. Đăng nhập thất bại
        toastr()->error('Tên đăng nhập hoặc mật khẩu không chính xác.');
        return redirect()->back()->withInput();
    }

    public function showloginForm(){
        return view('clients.pages.login');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        toastr()->success('Đăng xuất thành công.');
        return redirect()->route('login');
    }
}
