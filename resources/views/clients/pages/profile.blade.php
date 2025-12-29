@extends('layouts.client')

@section('title', 'Trang cá nhân')

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
                <li><a class="dropdown-item py-2" href="/change_password"><i class="fas fa-key me-2"></i> Đổi mật khẩu</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"><i
                            class="fas fa-sign-out-alt me-2"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" id="update-account" enctype="multipart/form-data">
        @method('PUT')
        <div class="content-wrapper">
            <h5 class="fw-bold mb-4 text-uppercase"><i class="fas fa-id-card me-2 text-primary"></i>Thông tin tài khoản
            </h5>

            <div class="row">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center p-4 mb-4">
                        <div class="position-relative d-inline-block mx-auto mb-3">
                            <img src="{{ asset('storage/'. $user->avatar) }}" id="userAvatarMain" class="rounded-circle border p-1"
                                style="width: 120px; height: 120px; object-fit: cover;">
                            <div class="profile-pic">
                                <input type="file" id="avatar" name="avatar" hidden accept="image/*">

                                <button
                                    class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle shadow"
                                    type="button"
                                    style="width: 32px; height: 32px; padding: 0;">
                                    <i class="fas fa-camera" style="font-size: 12px;"></i>
                                </button>
                            </div>

                        </div>

                        <h5 class="fw-bold mb-1">{{ $user->username }}</h5>
                        <p class="text-muted small mb-3">Thành viên chính thức</p>
                        <div class="btn-wrapper">
                            <button style="margin-bottom: 10px; border-radius: 30px" type="submit" id="btn-save-avatar" class="btn btn-primary btn-sm w-100 mt-2 d-none">
                                <i class="fas fa-save me-1"></i> Lưu ảnh đại diện
                            </button>
                        </div>

                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Hoạt động</span>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm p-4">
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Tên đăng nhập:</div>
                            <div class="col-sm-8 fw-bold">{{ $user->username }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Email:</div>
                            <div class="col-sm-8 fw-bold">{{ $user->email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Số dư hiện tại:</div>
                            <div class="col-sm-8 fw-bold text-danger">{{ number_format($user->balance) }}đ</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Tổng nạp:</div>
                            <div class="col-sm-8 fw-bold text-success">{{ number_format($user->total_deposit ?? 0) }}đ</div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-sm-4 text-muted">Ngày tham gia:</div>
                            <div class="col-sm-8 fw-bold">{{ $user->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection