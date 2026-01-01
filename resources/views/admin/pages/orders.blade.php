@extends('layouts.admin')

@section('title', 'Lịch sử đơn hàng')

@section('content')
<main class="main-content">
    <header class="top-header">
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="orderSearch" placeholder="Tìm mã đơn hoặc khách hàng...">
        </div>
        <div class="header-right">
            <div class="user-pill">
                <img src="{{ ($admin && $admin->avatar) ? asset('storage/'.$admin->avatar) : asset('assets/admin/img/avt.jpg') }}" alt="Admin">
                <span class="fw-bold small">{{ $admin->username ?? 'Admin' }}</span>
            </div>
        </div>
    </header>

    <div class="content-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Lịch sử đơn hàng</h4>
            <div class="badge bg-primary rounded-pill px-3 py-2">
                Tổng: <span id="totalOrders">{{ $orders->count() }}</span> đơn hàng
            </div>
        </div>

        <div class="row g-4" id="orderContainer">
            @forelse($orders as $order)
            <div class="col-xl-3 col-lg-4 col-md-6 order-card-item">
                <div class="user-card">
                    <div class="user-avatar-wrap d-flex align-items-center justify-content-center bg-light rounded-circle shadow-sm">
                        <i class="fas {{ $order->status == 1 ? 'fa-check-circle text-success' : 'fa-clock text-warning' }} fa-2x"></i>
                    </div>

                    <div class="user-name text-truncate mt-2">#{{ $order->order_number }}</div>
                    <div class="user-email mb-3">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</div>

                    <div class="fw-bold text-dark mb-1">{{ number_format($order->total_price) }}đ</div>
                    <div class="small text-muted text-truncate px-2 mb-3" title="{{ $order->product_name }}">
                        {{ $order->product_name }}
                    </div>

                    <span class="role-badge {{ $order->status == 1 ? 'role-user' : 'role-admin' }}">
                        {{ $order->status == 1 ? 'Hoàn thành' : 'Chờ xử lý' }}
                    </span>

                    <div class="user-footer mt-4">
                        <div class="verify-status">
                            <i class="fas fa-user-circle text-muted"></i>
                            <span class="text-dark fw-medium small text-truncate" style="max-width: 100px;">{{ $order->customer_name }}</span>
                        </div>
                        <div class="dropdown">
                            <div class="more-btn" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                <li><a href="{{ route('admin.orders.order_detail', $order->id) }}" class="dropdown-item small">
                                        <i class="fas fa-eye me-2"></i> Chi tiết
                                    </a></li>
                                <li>
                                    <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" onsubmit="return confirm('Xóa đơn này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item small text-danger"><i class="fas fa-trash me-2"></i> Xóa đơn</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">Không có dữ liệu đơn hàng nào.</div>
            @endforelse
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/orders.js') }}"></script>
<script src="{{ asset('assets/admin/js/sidebar.js') }}"></script>
@endpush