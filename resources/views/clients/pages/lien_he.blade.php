@extends('layouts.client')

@section('title', 'Hỗ trợ & Bảo hành')

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
        <h5 class="fw-bold mb-4 text-uppercase"><i class="fas fa-shield-alt me-2 text-primary"></i>Hỗ trợ & Chính sách bảo hành</h5>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center text-lg-start">
                        <h6 class="fw-bold mb-4 text-primary text-uppercase small">Thông tin trực tuyến</h6>

                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="fab fa-facebook text-primary fs-4"></i>
                            </div>
                            <div class="text-start">
                                <p class="text-muted small mb-0">Facebook Cá Nhân</p>
                                <a href="https://www.facebook.com/layfblamgivayanhzai" target="_blank" class="text-dark fw-bold text-decoration-none">admin.binhxutudong</a>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="fas fa-comment-dots text-info fs-4"></i>
                            </div>
                            <div class="text-start">
                                <p class="text-muted small mb-0">Zalo Hỗ Trợ</p>
                                <p class="fw-bold mb-0">0889639655</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="fas fa-clock text-danger fs-4"></i>
                            </div>
                            <div class="text-start">
                                <p class="text-muted small mb-0">Thời gian làm việc</p>
                                <p class="fw-bold mb-0 text-nowrap">08:00 AM - 23:00 PM</p>
                            </div>
                        </div>

                        <hr class="my-4">
                        <a href="https://t.me/yourgroup" target="_blank" class="btn btn-primary w-100 py-3 fw-bold shadow-sm">
                            <i class="fab fa-telegram-plane me-2 fs-5"></i> THAM GIA BOX TELEGRAM
                        </a>
                        <a href="https://zalo.me/0889639655" target="_blank" class="btn btn-primary w-100 py-3 fw-bold shadow-sm" style="margin-top:20px;">
                            <i class="fas fa-headset me-2"></i> THAM GIA BOX ZALO
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 text-uppercase text-primary small"><i class="fas fa-check-circle me-2"></i>Thông tin bảo hành</h6>
                        <p class="text-muted small">Chúng tôi cam kết cung cấp dịch vụ tốt nhất. Dưới đây là các mốc thời gian bảo hành:</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded-3 border-start border-primary border-4 shadow-sm">
                                    <div class="fw-bold text-dark mb-1">Tài khoản (Clone/Via)</div>
                                    <small class="text-muted">Bảo hành sai pass, sai định dạng lúc mua trong vòng <strong>24h</strong>.</small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded-3 border-start border-warning border-4 shadow-sm">
                                    <div class="fw-bold text-dark mb-1">Dịch vụ Xu/Tương tác</div>
                                    <small class="text-muted">Bảo hành tụt quá 10% trong vòng <strong>7 ngày</strong> kể từ lúc mua.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 text-uppercase text-danger small"><i class="fas fa-exclamation-triangle me-2"></i>Chính sách từ chối bảo hành</h6>
                        <div class="list-group list-group-flush small">
                            <div class="list-group-item border-0 px-0 d-flex align-items-start">
                                <i class="fas fa-caret-right text-primary me-2 mt-1"></i>
                                <span><strong>Điều kiện:</strong> Tài khoản phải còn nguyên trạng, chưa thay đổi thông tin quá nhiều ngay sau khi mua.</span>
                            </div>
                            <div class="list-group-item border-0 px-0 d-flex align-items-start">
                                <i class="fas fa-caret-right text-primary me-2 mt-1"></i>
                                <span><strong>Thời gian xử lý:</strong> Các khiếu nại sẽ được xử lý từ <strong>15 phút đến 2 giờ</strong> làm việc.</span>
                            </div>
                            <div class="list-group-item border-0 px-0 d-flex align-items-start">
                                <i class="fas fa-caret-right text-danger me-2 mt-1"></i>
                                <span><strong>Từ chối:</strong> Không bảo hành nếu khách làm checkpoint do đổi IP lạ hoặc đổi pass ngay lập tức.</span>
                            </div>
                        </div>
                        <div class="mt-3 p-2 bg-danger-subtle rounded text-danger small italic border border-danger border-dashed">
                            <i class="fas fa-info-circle me-1"></i> Quý khách vui lòng kiểm tra kỹ tài khoản ngay sau khi hệ thống bàn giao.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection