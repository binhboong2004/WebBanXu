@extends('layouts.client')

@section('title', 'Công cụ hỗ trợ')

@section('content')
<div class="main-content">
    <div class="top-navbar border-bottom d-flex align-items-center px-3">
        <div class="d-flex align-items-center">
            @if(Auth::check())
                <button class="btn btn-sm btn-light border me-3">
                    <i class="fas fa-wallet text-primary"></i> Ví: {{ number_format($user->balance) }}đ
                </button>
            @endif
        </div>

        <div class="ms-auto">
            @if(Auth::check())
                <div class="user-info d-flex align-items-center dropdown">
                    <div class="d-flex align-items-center cursor-pointer" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('storage/'. $user->avatar) }}" class="rounded-circle me-2" style="width: 30px; height:30px; object-fit: cover;">
                        <strong class="me-1">{{ $user->username }}</strong>
                        <i class="fas fa-caret-down small"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                        <li><a class="dropdown-item py-2" href="{{ route('profile') }}"><i class="fas fa-user-circle me-2"></i> Trang cá nhân</a></li>
                        <li><a class="dropdown-item py-2" href="/change_password"><i class="fas fa-key me-2"></i> Đổi mật khẩu</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Đăng xuất</a></li>
                    </ul>
                </div>
            @else
                <div class="dropdown">
                    <button class="btn btn-sm btn-primary dropdown-toggle fw-bold px-3" type="button" id="guestMenu" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 30px;">
                        <i class="fas fa-user-circle me-1"></i> TÀI KHOẢN
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="guestMenu">
                        <li><a class="dropdown-item py-2" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-2 text-primary"></i> Đăng nhập</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('register') }}"><i class="fas fa-user-plus me-2 text-success"></i> Đăng ký</a></li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="content-wrapper mt-4">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="fw-bold text-primary mb-2 text-uppercase"><i class="fas fa-tools me-2"></i>Công cụ miễn phí</h4>
                        <p class="text-muted mb-0">Hệ thống tổng hợp các công cụ hỗ trợ tốt nhất cho dân chạy TraoDoiSub và TuongTacCheo.</p>
                    </div>
                    <div class="d-none d-md-block">
                        <i class="fas fa-laptop-code fa-3x text-light"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm overflow-hidden h-100">
                    <div class="card-header bg-dark text-white text-center py-3 fw-bold">
                        <i class="fas fa-key me-2 text-warning"></i>GET CODE 2FA (2FA.LIVE)
                    </div>
                    <div class="card-body text-center p-5">
                        <div class="icon-circle bg-warning bg-opacity-10 text-warning mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; border-radius: 50%;">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Lấy mã bảo mật 2 lớp</h5>
                        <p class="text-muted small mb-4">Giải mã chuỗi ký tự 2FA để lấy mã OTP 6 số dùng đăng nhập Facebook, TikTok, Instagram.</p>
                        <a href="https://2fa.live/" target="_blank" class="btn btn-warning w-100 fw-bold py-2 shadow-sm text-dark">
                            <i class="fas fa-external-link-alt me-2"></i> MỞ TRÌNH LẤY MÃ
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm overflow-hidden h-100">
                    <div class="card-header bg-primary text-white text-center py-3 fw-bold">
                        <i class="fas fa-id-card me-2"></i>GET ID FACEBOOK (TDS)
                    </div>
                    <div class="card-body text-center p-5">
                        <div class="icon-circle bg-primary bg-opacity-10 text-primary mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; border-radius: 50%;">
                            <i class="fab fa-facebook-f fa-2x"></i>
                        </div>
                        <h5 class="fw-bold">Lấy UID Facebook</h5>
                        <p class="text-muted small mb-4">Chuyển đổi đường dẫn (link) trang cá nhân hoặc fanpage sang dạng dãy số ID (UID) nhanh chóng.</p>
                        <a href="https://id.traodoisub.com/" target="_blank" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">
                            <i class="fas fa-search me-2"></i> MỞ TRÌNH LẤY ID
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info border-0 shadow-sm p-4 mt-2">
            <h6 class="fw-bold"><i class="fas fa-info-circle me-2"></i>Lưu ý nhỏ:</h6>
            <p class="small mb-0">Các công cụ này được cung cấp bởi bên thứ ba (2fa.live & TraoDoiSub). Chúng tôi không lưu trữ bất kỳ dữ liệu cá nhân nào của bạn khi bạn sử dụng các liên kết này.</p>
        </div>
    </div>
</div>
@endsection