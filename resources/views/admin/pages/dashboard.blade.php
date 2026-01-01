@extends('layouts.admin')

@section('title', 'Trang chủ Admin')

@section('content')
<main class="main-content">
    <header class="top-header">
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Tìm kiếm nhanh...">
        </div>
        <div class="header-right">
            <div class="user-pill">
                <img src="{{ $user->avatar ? asset('storage/'. $user->avatar) : asset('assets/admin/img/avt.jpg') }}" alt="Admin">
                <span class="fw-bold small">{{ $user->username }}</span>
            </div>
        </div>
    </header>

    <div class="content-body">
        {{-- Stat Cards: Hiển thị số liệu thực tế --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-wrap bg-blue-soft text-primary"><i class="fas fa-shopping-cart"></i></div>
                    <div><p>Đơn hàng</p><h4>{{ number_format($totalOrders) }}</h4></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-wrap bg-purple-soft text-purple"><i class="fas fa-user"></i></div>
                    <div><p>Người dùng</p><h4>{{ number_format($totalUsers) }}</h4></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-wrap bg-cyan-soft text-cyan"><i class="fas fa-database"></i></div>
                    <div><p>Tài khoản</p><h4>{{ number_format($totalProducts) }}</h4></div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Biểu đồ tăng trưởng --}}
            <div class="col-lg-8">
                <div class="card h-100 p-4">
                    <h6 class="fw-bold mb-4">BIỂU ĐỒ 10 NGÀY QUA</h6>
                    <div style="height: 350px;">
                        <canvas id="mainChart" 
                            data-labels='@json($chartData["labels"])' 
                            data-orders='@json($chartData["orders"])' 
                            data-users='@json($chartData["users"])'>
                        </canvas>
                    </div>
                </div>
            </div>

            {{-- Dòng tiền gần đây --}}
            <div class="col-lg-4">
                <div class="card h-100 p-4">
                    <h6 class="fw-bold mb-4 border-bottom pb-3">DÒNG TIỀN MỚI NHẤT</h6>
                    <div class="cash-flow-list">
                        @foreach($recentFlows as $flow)
                        <div class="cash-item d-flex align-items-center mb-4">
                            <div class="item-icon {{ $flow->type == 'in' ? 'in' : 'out' }} me-3">
                                <i class="fas {{ $flow->type == 'in' ? 'fa-plus' : 'fa-minus' }}"></i>
                            </div>
                            <div class="flex-grow-1 text-truncate pe-2">
                                <span class="d-block fw-bold small text-truncate">{{ $flow->note }}</span>
                                <span class="text-muted smallest">{{ $flow->username }} • {{ \Carbon\Carbon::parse($flow->created_at)->diffForHumans() }}</span>
                            </div>
                            <span class="{{ $flow->type == 'in' ? 'text-success' : 'text-danger' }} fw-bold small">
                                {{ $flow->type == 'in' ? '+' : '-' }}{{ number_format($flow->amount) }}đ
                            </span>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-auto">
                        <a href="{{ route('admin.finance.cashflow') }}" class="text-primary small text-decoration-none fw-bold">Chi tiết dòng tiền</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="{{ asset('assets/admin/js/admin_script.js') }}"></script>
@endsection