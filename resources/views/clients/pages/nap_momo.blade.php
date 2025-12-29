@extends('layouts.client')

@section('title', 'Nạp tiền MoMo')

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
                    <div class="d-flex align-items-center cursor-pointer" data-bs-toggle="dropdown">
                        <img src="{{ asset('storage/'. $user->avatar) }}" class="rounded-circle me-2" style="width: 30px; height:30px; object-fit: cover;">
                        <strong>{{ $user->username }}</strong>
                        <i class="fas fa-caret-down small ms-1"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                        <li><a class="dropdown-item py-2" href="{{ route('profile') }}"><i class="fas fa-user-circle me-2"></i> Trang cá nhân</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('password.change') }}"><i class="fas fa-key me-2"></i> Đổi mật khẩu</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Đăng xuất</a></li>
                    </ul>
                </div>
            @else
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary fw-bold px-3">ĐĂNG NHẬP</a>
                </div>
            @endif
        </div>
    </div>

    <div class="content-wrapper mt-4">
        <h5 class="fw-bold mb-3 text-uppercase"><i class="fas fa-mobile-alt me-2 text-primary"></i>Nạp tiền qua MoMo</h5>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center p-4 h-100">
                    <div class="mb-3">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=2|99|0889639655|VU%20DUY%20BINH||0|0|0|NAPTIEN%20{{ Auth::check() ? $user->username : 'KHACH' }}" 
                             class="img-fluid border p-2 bg-white shadow-sm" style="max-width: 220px; border-radius: 15px; border: 2px solid #a50064 !important;">
                    </div>
                    <h6 class="fw-bold text-uppercase mb-3" style="color: #a50064;">Ví MoMo Chuyển Khoản</h6>
                    <div class="text-start bg-light p-3 rounded-3 border">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Số điện thoại:</span>
                            <strong class="text-dark">0889639655</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Chủ ví:</span>
                            <strong class="text-dark">VŨ DUY BÌNH</strong>
                        </div>
                        <hr class="my-2">
                        <div class="text-center">
                            <span class="text-muted small d-block mb-1">NỘI DUNG CHUYỂN KHOẢN:</span>
                            <div class="bg-danger-subtle text-danger fw-bold fs-5 p-2 border border-danger border-dashed rounded" id="momoContent">
                                NAPTIEN {{ Auth::check() ? $user->username : 'KHACH' }}
                            </div>
                            <button class="btn btn-sm btn-dark mt-2 w-100 py-2" onclick="copyMomo()">
                                <i class="fas fa-copy me-1"></i> SAO CHÉP NỘI DUNG
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-info-circle text-warning me-2"></i>THÔNG TIN CẦN BIẾT</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="alert alert-warning border-0 small mb-4">
                            <ul class="mb-0 ps-3">
                                <li class="mb-2">Bạn cần chuyển khoản chính xác <strong>Nội dung</strong> để được cộng tiền tự động.</li>
                                <li class="mb-2">Hệ thống xử lý giao dịch tự động từ 1 - 3 phút.</li>
                                <li>Nếu sau 15 phút chưa nhận được tiền, vui lòng liên hệ Admin.</li>
                            </ul>
                        </div>

                        <h6 class="fw-bold small text-muted text-uppercase mb-2">Bảng giá trị nhận thực</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover border small align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Số tiền nạp</th>
                                        <th class="text-center">Tỉ lệ</th>
                                        <th class="text-end">Nhận thực</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10,000đ</td>
                                        <td class="text-center">100%</td>
                                        <td class="text-end fw-bold text-success">10,000đ</td>
                                    </tr>
                                    <tr>
                                        <td>50,000đ</td>
                                        <td class="text-center">100%</td>
                                        <td class="text-end fw-bold text-success">50,000đ</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td>100,000đ</td>
                                        <td class="text-center">105%</td>
                                        <td class="text-end fw-bold text-primary">105,000đ</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td>500,000đ</td>
                                        <td class="text-center">110%</td>
                                        <td class="text-end fw-bold text-primary">550,000đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-grid mt-3">
                            <a href="https://zalo.me/0889639655" target="_blank" class="btn btn-outline-primary btn-sm fw-bold">
                                <i class="fab fa-facebook-messenger me-1"></i> Báo lỗi nạp tiền (Gặp Admin)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyMomo() {
        var content = document.getElementById("momoContent").innerText;
        navigator.clipboard.writeText(content);
        alert("Đã sao chép nội dung: " + content);
    }
</script>
@endsection