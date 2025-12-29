@extends('layouts.client')

@section('title', 'Đổi mật khẩu')

@section('content')
    <div class="main-content">
        <div class="top-navbar border-bottom">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-light border me-3"><i class="fas fa-wallet text-primary"></i> Ví:
                    {{ number_format($user->balance) }}đ</button>
            </div>
            <div class="user-info d-flex align-items-center dropdown">
                <div class="d-flex align-items-center cursor-pointer" data-bs-toggle="dropdown">
                    <img src="{{ asset('storage/'. $user->avatar) }}" class="rounded-circle me-2"
                        style="width: 30px; height:30px; object-fit: cover;">
                    <strong>{{ $user->username }}</strong>
                    <i class="fas fa-caret-down small ms-1"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li><a class="dropdown-item py-2" href="{{ route('profile') }}"><i class="fas fa-user-circle me-2"></i> Trang
                            cá nhân</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('password.change') }}"><i class="fas fa-key me-2"></i> Đổi mật khẩu</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"><i
                                class="fas fa-sign-out-alt me-2"></i> Đăng xuất</a></li>
                </ul>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0 fw-bold text-uppercase"><i class="fas fa-lock me-2 text-warning"></i>Đổi mật
                                khẩu mới</h6>
                        </div>
                        <div class="card-body p-4">
                            <form id="changePassForm" action="{{ route('profile.changePassword') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Mật khẩu hiện tại</label>
                                    <input type="password" name="current_password" class="form-control" placeholder="Nhập mật khẩu đang dùng"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Mật khẩu mới</label>
                                    <input type="password" name="new_password" class="form-control" placeholder="Tối thiểu 6 ký tự"
                                        required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">Xác nhận mật khẩu mới</label>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Nhập lại mật khẩu mới"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">CẬP NHẬT MẬT
                                    KHẨU</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection