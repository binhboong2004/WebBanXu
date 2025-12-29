@extends('layouts.client')

@section('title', 'Nạp tiền ngân hàng')

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
                            <li><a class="dropdown-item py-2" href="{{ route('password.change') }}"><i class="fas fa-key me-2"></i> Đổi mật khẩu</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Đăng xuất</a></li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-primary fw-bold px-3 shadow-sm" style="border-radius: 30px;">ĐĂNG NHẬP</a>
                        <a href="{{ route('register') }}" class="btn btn-sm btn-outline-primary fw-bold px-3" style="border-radius: 30px;">ĐĂNG KÝ</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="content-wrapper mt-4">
            <h5 class="fw-bold mb-3 text-uppercase"><i class="fas fa-university me-2 text-primary"></i>Nạp tiền ngân hàng / Momo</h5>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm text-center p-4 h-100">
                        <div class="qr-code-wrapper mb-3">
                            <img src="https://img.vietqr.io/image/MBBank-6802122004-compact2.png?amount=&addInfo=NAPTIEN%20{{ Auth::check() ? $user->username : 'KHACH' }}&accountName=VU%20DUY%20BINH" 
                                 class="img-fluid border p-2 bg-white shadow-sm" 
                                 style="max-width: 220px; border-radius: 15px;">
                        </div>
                        
                        <h6 class="fw-bold text-uppercase text-primary mb-3">Ngân hàng MB Bank (Tự động)</h6>
                        
                        <div class="bank-details text-start bg-light p-3 rounded-3 border">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Số tài khoản:</span>
                                <strong class="text-dark" id="stk">6802122004</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Chủ tài khoản:</span>
                                <strong class="text-dark">VŨ DUY BÌNH</strong>
                            </div>
                            <hr class="my-2">
                            <div class="text-center">
                                <span class="text-muted small d-block mb-1">NỘI DUNG CHUYỂN KHOẢN:</span>
                                <div class="bg-danger-subtle text-danger fw-bold fs-5 p-2 border border-danger border-dashed rounded" id="transferContent">
                                    NAPTIEN {{ Auth::check() ? $user->username : 'KHACH' }}
                                </div>
                                <button class="btn btn-sm btn-dark mt-2 w-100 py-2" onclick="copyContent()">
                                    <i class="fas fa-copy me-1"></i> SAO CHÉP NỘI DUNG
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-info-circle text-warning me-2"></i>HƯỚNG DẪN NẠP TIỀN</h6>
                        </div>
                        <div class="card-body">
                            <div class="step-item d-flex mb-3">
                                <div class="step-number me-3 text-white bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 25px; height: 25px; flex-shrink: 0; font-size: 12px;">1</div>
                                <p class="small text-muted mb-0">Sử dụng App Ngân hàng hoặc Momo để quét mã QR phía bên trái hoặc nhập tay thông tin tài khoản.</p>
                            </div>
                            <div class="step-item d-flex mb-3">
                                <div class="step-number me-3 text-white bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 25px; height: 25px; flex-shrink: 0; font-size: 12px;">2</div>
                                <p class="small text-muted mb-0">Ghi chính xác <strong>Nội dung chuyển khoản</strong>. Nếu ghi sai nội dung, hệ thống không thể cộng tiền tự động.</p>
                            </div>
                            <div class="step-item d-flex mb-3">
                                <div class="step-number me-3 text-white bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 25px; height: 25px; flex-shrink: 0; font-size: 12px;">3</div>
                                <p class="small text-muted mb-0">Tiền sẽ được cộng vào tài khoản của bạn sau 1 - 3 phút (Tối đa 15 phút tùy ngân hàng).</p>
                            </div>

                            <div class="alert alert-info border-0 mt-4 small mb-0">
                                <i class="fas fa-headset me-2"></i> Nếu quá 15 phút chưa nhận được tiền, vui lòng liên hệ Admin <strong>0889639655</strong> để được hỗ trợ thủ công.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyContent() {
            var content = document.getElementById("transferContent").innerText;
            navigator.clipboard.writeText(content).then(function() {
                if(typeof toastr !== 'undefined') {
                    toastr.success("Đã sao chép nội dung: " + content);
                } else {
                    alert("Đã sao chép nội dung: " + content);
                }
            });
        }
    </script>
@endsection