@extends('layouts.client')

@section('title', 'Lịch sử mua')

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
            @endif
        </div>
    </div>

    <div class="content-wrapper mt-4">
        <h5 class="fw-bold mb-3 text-uppercase"><i class="fas fa-history me-2 text-primary"></i>Lịch sử mua hàng</h5>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">STT</th>
                            <th>Mã đơn</th>
                            <th>Sản phẩm</th>
                            <th class="text-center">Thanh toán</th>
                            <th class="text-center">Thời gian</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary border">
                                    #{{ $order->order_number }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">
                                    {{ $order->account->category->name ?? 'N/A' }} - {{ number_format($order->account->xu_amount) }} Xu
                                </div>
                                <small class="text-muted small">Hệ thống: {{ $order->account->category->name ?? 'Không xác định' }}</small>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-danger">{{ number_format($order->total_price) }}đ</span>
                            </td>
                            <td class="text-center text-muted small">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info text-white fw-bold px-3 shadow-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalXemAcc"
                                    onclick="showAccount('{{ $order->account->acc_username }}', '{{ $order->account->acc_password }}')">
                                    <i class="fas fa-eye me-1"></i> XEM ACC
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" style="width: 50px; opacity: 0.5" class="mb-2"><br>
                                Bạn chưa mua tài khoản nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalXemAcc" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white py-3">
                <h5 class="modal-title fw-bold text-uppercase fs-6" id="modalLabel">
                    <i class="fas fa-key me-2 text-warning"></i>Thông tin tài khoản đã mua
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small text-muted fw-bold text-uppercase">Định dạng: Username | Password</label>
                    <div class="input-group border rounded-3 overflow-hidden">
                        <input type="text" id="accContent" class="form-control border-0 fw-bold text-danger bg-light py-2" value="tk_traodoisub_01 | pass123456" readonly>
                        <button class="btn btn-dark px-3" type="button" onclick="copyToClipboard()">
                            <i class="fas fa-copy me-1"></i> Sao chép
                        </button>
                    </div>
                </div>
                <div class="alert alert-warning border-0 bg-warning-subtle py-3 mb-0 small rounded-3">
                    <div class="d-flex">
                        <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                        <div>
                            <strong>Quan trọng:</strong> Vui lòng kiểm tra và thay đổi thông tin mật khẩu ngay sau khi nhận tài khoản. Chúng tôi không chịu trách nhiệm nếu bạn không bảo mật tài khoản.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-3">
                <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">ĐÓNG</button>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        var copyText = document.getElementById("accContent");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);

        // Nếu bạn có dùng toastr
        if (typeof toastr !== 'undefined') {
            toastr.success("Đã sao chép vào bộ nhớ tạm!");
        } else {
            alert("Đã sao chép tài khoản!");
        }
    }

    function showAccount(username, password) {
        document.getElementById('accContent').value = username + ' | ' + password;
    }
</script>
@endsection