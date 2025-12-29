@extends('layouts.client')

@section('title', 'Trang chủ')

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
                    <li>
                        <hr class="dropdown-divider">
                    </li>
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
                <div class="row align-items-center">
                    <div class="col-md-8 border-end">
                        <h4 class="fw-bold text-primary mb-3">WEBSITE BÁN XU TỰ ĐỘNG <span class="badge bg-primary fs-6">V1.0</span></h4>
                        <p class="text-muted">Hệ thống cung cấp tài khoản <b>Traodoisub</b> và <b>Tuongtaccheo</b> tự động. An toàn - Bảo mật - Uy tín.</p>
                    </div>
                    <div class="col-md-4 ps-4">
                        <h6 class="fw-bold"><i class="fas fa-headset text-danger me-2"></i>Hỗ trợ trực tuyến</h6>
                        <p class="small text-muted mb-1">Zalo: <strong>0889639655</strong></p>
                        <button class="btn btn-sm btn-outline-primary w-100">Tham gia Box Zalo</button>
                    </div>
                </div>
            </div>
        </div>

        <h5 class="fw-bold mt-4 mb-3 text-uppercase">Danh sách tài khoản đang bán</h5>
        <div class="row">
            @forelse($accountGroups as $index => $group)
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                    <div class="card-header bg-dark text-white text-center py-3 fw-bold text-uppercase">
                        {{ $group->category->name ?? 'Tài khoản' }}
                    </div>
                    <div class="card-body text-center">
                        <h2 class="text-primary fw-bold mb-0">{{ number_format($group->xu_amount) }}</h2>
                        <p class="text-muted small">XU TRONG TÀI KHOẢN</p>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Số lượng còn:</span>
                            <span class="badge bg-success">{{ $group->total }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Đơn giá:</span>
                            <span class="fw-bold text-danger">{{ number_format($group->price) }}đ</span>
                        </div>

                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text bg-light">Số lượng mua</span>
                            <input type="number" id="qty_{{ $index }}" class="form-control text-center fw-bold"
                                value="1" min="1" max="{{ $group->total }}">
                        </div>

                        <button class="btn btn-warning w-100 fw-bold py-2 shadow-sm"
                            onclick="openBuyModal(`{{ $group->category->name }} {{ $group->xu_amount }} xu`, `{{ $group->price }}`, `qty_{{ $index }}`)">
                            <i class="fas fa-shopping-cart me-1"></i> MUA NGAY
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">Hiện tại chưa có tài khoản nào được đăng bán.</div>
            </div>
            @endforelse
        </div>
    </div>
    <div class="row mt-4" style="margin-left:10px; margin-right:10px;">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-dark text-white py-2">
                    <h6 class="mb-0 text-uppercase fw-bold small"><i class="fas fa-shopping-cart me-2"></i>Đơn hàng gần đây</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                        @forelse($recentOrders as $order)
                        <div class="list-group-item border-start-0 border-end-0 py-2 px-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center overflow-hidden">
                                    <i class="fas fa-shopping-basket text-muted me-2 small"></i>
                                    <div class="text-truncate">
                                        <span class="text-success fw-bold small">...{{ substr($order->user->username, -3) }}</span>
                                        <span class="small">Mua</span>
                                        <span class="fw-bold text-danger small">1</span>
                                        <span class="small text-dark fw-bold">{{ $order->account->category->name ?? 'Tài khoản' }}</span>
                                        <span class="badge bg-info-subtle text-info mx-1" style="font-size: 10px;">{{ number_format($order->account->xu_amount) }} xu</span>
                                        <span class="small text-primary fw-bold">- {{ number_format($order->total_price) }}đ</span>
                                    </div>
                                </div>
                                <span class="badge bg-primary small fw-normal ms-2" style="font-size: 10px;">{{ $order->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="p-3 text-center text-muted small">Chưa có đơn hàng nào</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-dark text-white py-2">
                    <h6 class="mb-0 text-uppercase fw-bold small"><i class="fas fa-wallet me-2"></i>Nạp tiền gần đây</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                        @forelse($recentRecharges as $recharge)
                        <div class="list-group-item border-start-0 border-end-0 py-2 px-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-university text-muted me-2 small"></i>
                                    <div>
                                        <span class="text-success fw-bold small">...{{ substr($recharge->user->username, -3) }}</span>
                                        <span class="small">thực hiện nạp</span>
                                        <span class="fw-bold text-primary small">{{ number_format($recharge->amount) }}đ</span>
                                        <span class="small"> - </span>
                                        <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size: 10px;">{{ $recharge->method }}</span>
                                    </div>
                                </div>
                                <span class="badge bg-primary small fw-normal ms-2" style="font-size: 10px;">{{ $recharge->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="p-3 text-center text-muted small">Chưa có giao dịch nạp tiền</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmBuyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning py-3">
                <h5 class="modal-title fw-bold text-uppercase"><i class="fas fa-check-circle me-2"></i>Xác nhận đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="text-muted mb-1 small text-uppercase">Bạn đang thực hiện mua sản phẩm:</p>
                <h5 id="modalProdName" class="fw-bold text-primary mb-4">Tên sản phẩm</h5>
                <div class="bg-light p-3 rounded-3 border mb-3 text-start">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tổng thanh toán:</span>
                        <strong id="modalProdPrice" class="text-danger">0đ</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Hình thức:</span>
                        <strong class="text-dark">Ví tài khoản</strong>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-3">
                <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">HỦY</button>
                <button type="button" class="btn btn-warning fw-bold px-4 shadow-sm" onclick="submitPurchase()">XÁC NHẬN MUA</button>
            </div>
        </div>
    </div>
</div>

@endsection