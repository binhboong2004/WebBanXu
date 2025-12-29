<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu - BINHXUTUDONG.COM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/clients/css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="auth-body">

<div class="card auth-card">
    <div class="auth-header text-center mt-4">
        <a href="/"><img src="{{ asset('assets/clients/img/logo.png') }}" alt="Logo" style="max-width: 150px;"></a>
        <h4 class="fw-bold mt-2">KHÔI PHỤC MẬT KHẨU</h4>
        <p class="text-muted small">Nhập email của bạn để nhận liên kết đặt lại mật khẩu</p>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('password.email') }}" method="POST" id="forgot-password-form">
            @csrf
            <div class="mb-4">
                <label class="form-label small fw-bold">Email đăng ký</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="nguyenvana@gmail.com" required>
                </div>
                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary w-100 btn-auth shadow-sm mb-3">Gửi liên kết xác nhận</button>
            <p class="text-center small text-muted">Quay lại <a href="{{ route('login') }}" class="auth-link">Đăng nhập</a></p>
        </form>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>