@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<main class="main-content">
    <header class="top-header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.orders.orders') }}" class="btn btn-light rounded-circle shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mb-0">Chi tiết đơn hàng <span class="text-primary">#{{ $order->order_number }}</span></h4>
        </div>
    </header>

    <div class="content-body">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                {{-- Thông tin sản phẩm --}}
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0"><i class="fas fa-shopping-cart me-2 text-primary"></i>Thông tin sản phẩm</h5>
                        <span class="badge {{ $order->status == 1 ? 'bg-success' : 'bg-warning' }} rounded-pill px-3 py-2">
                            {{ $order->status == 1 ? 'Hoàn thành' : 'Chờ xử lý' }}
                        </span>
                    </div>

                    <div class="d-flex align-items-center p-3 bg-light rounded-4 mb-4">
                        <div class="product-icon-box me-4 bg-white p-3 rounded-circle shadow-sm">
                            <i class="fas fa-box-open fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="small text-muted">Tên tài khoản / Gói dịch vụ</div>
                            <div class="fw-bold fs-5">{{ $order->product_name }}</div>
                            <div class="text-danger small">Mật khẩu: <strong>{{ $order->product_password }}</strong></div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Thành tiền</div>
                            <div class="fs-4 fw-bold text-primary">{{ number_format($order->total_price) }}đ</div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="small text-muted">Mã đơn hàng</div>
                            <div class="fw-bold">{{ $order->order_number }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="small text-muted">Thời gian mua</div>
                            <div class="fw-bold">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="small text-muted">Phương thức</div>
                            <div class="fw-bold">Số dư hệ thống</div>
                        </div>
                    </div>
                </div>

                {{-- Thông tin người mua --}}
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-4"><i class="fas fa-user-shield me-2 text-primary"></i>Thông tin khách hàng</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="small text-muted">Tên khách hàng</div>
                            <div class="d-flex align-items-center gap-3 mt-1">
                                <img src="{{ $order->customer_avatar ? asset('storage/'.$order->customer_avatar) : asset('assets/admin/img/avt.jpg') }}" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover;">
                                <div class="fw-bold">{{ $order->customer_name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">Email liên hệ</div>
                            <div class="fw-bold mt-1">{{ $order->customer_email }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">ID Người dùng</div>
                            <div class="text-muted mt-1">#USR-{{ $order->user_id }}</div>
                        </div>
                    </div>
                </div>

                {{-- Hành động --}}
                <div class="d-flex gap-3 justify-content-end">
                    <button class="btn btn-outline-secondary px-4 rounded-pill" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>In hóa đơn
                    </button>
                    <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn đơn hàng này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4 rounded-pill">
                            <i class="fas fa-trash me-2"></i>Xóa đơn hàng
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection