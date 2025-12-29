<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - BINHXUTUDONG.COM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/clients/css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="auth-body">

<div class="card auth-card">
    <div class="auth-header text-center mt-4">
        <a href="/"><img src="{{ asset('assets/clients/img/logo.png') }}" alt="Logo" style="max-width: 150px;"></a>
        <h4 class="fw-bold mt-2">CHÀO MỪNG TRỞ LẠI</h4>
        <p class="text-muted small">Vui lòng đăng nhập để tiếp tục</p>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('post-login') }}" method="POST" id="login-form">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold">Tên đăng nhập</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Tên tài khoản" value="{{ old('username') }}" required>
                </div>
                @error('username')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control" id="loginPass" placeholder="Mật khẩu của bạn" required>
                </div>
                @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
            <div class="d-flex justify-content-between mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Ghi nhớ tôi</label>
                </div>
                <a href="{{ route('password.request') }}" class="auth-link small">Quên mật khẩu?</a>
            </div>
            <button type="submit" class="btn btn-primary w-100 btn-auth shadow-sm mb-3">Đăng Nhập</button>
            <p class="text-center small text-muted">Chưa có tài khoản? <a href="{{ route('register') }}" class="auth-link">Đăng ký ngay</a></p>
        </form>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/clients/js/custom.js') }}"></script>
</body>
</html>