<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Lại Mật Khẩu - BINHXUTUDONG.COM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/clients/css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="auth-body">

    <div class="card auth-card">
        <div class="auth-header text-center mt-4">
            <h4 class="fw-bold">THIẾT LẬP MẬT KHẨU MỚI</h4>
            <p class="text-muted small">Vui lòng nhập mật khẩu mới cho tài khoản của bạn</p>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('password.update') }}" method="POST" id="reset-password-form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="form-label small fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" readonly>
                </div>
                @error('email')
                <span class="text-danger small">{{ $message }}</span>
                @enderror

                <div class="mb-3">
                    <label class="form-label small fw-bold">Mật khẩu mới</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Tối thiểu 6 ký tự" required>
                    </div>
                </div>
                @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror

                <div class="mb-4">
                    <label class="form-label small fw-bold">Xác nhận mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-check-double text-muted"></i></span>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-auth shadow-sm mb-3">Cập nhật mật khẩu</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/clients/js/custom.js') }}"></script>
</body>

</html>