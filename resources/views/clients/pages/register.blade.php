<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - BINHXUTUDONG.COM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/clients/css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="auth-body">

    <div class="card auth-card">
        <div class="auth-header">
            <h3 class="fw-bold text-primary">TẠO TÀI KHOẢN</h3>
            <p class="text-muted small">Tham gia cùng hàng ngàn thành viên khác</p>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('post-register') }}" method="POST" id="register-form">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold">Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control" placeholder="Nhập tài khoản muốn tạo" value="{{ old('name') }}" required>
                    @error('username')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nguyenvana@gmail.com" value="{{ old('email') }}" required>
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label small fw-bold">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••" required>
                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label small fw-bold">Nhập lại</label>
                        <input type="password" name="comfirmpassword" class="form-control" placeholder="••••••" required>
                        @error('confirmpassword')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-4 small text-muted">
                    Bằng cách đăng ký, bạn đồng ý với <a href="#" class="auth-link">Điều khoản hệ thống</a>.
                </div>
                <button type="submit" class="btn btn-dark w-100 btn-auth shadow-sm mb-3">Đăng Ký</button>
                <p class="text-center small text-muted">Đã có tài khoản? <a href="{{ route('login')}}" class="auth-link">Đăng
                        nhập</a></p>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/clients/js/login.js') }}"></script>
</body>

</html>