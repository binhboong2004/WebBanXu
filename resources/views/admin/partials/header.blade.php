@php
    $userOpen     = request()->routeIs('admin.user_list');
    $categoryOpen = request()->routeIs('admin.categories.*');
    $productOpen  = request()->routeIs('admin.products.*');
@endphp

<div class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('assets/admin/img/logo.png') }}" alt="Logo" class="admin-logo">
    </div>

    <nav class="sidebar-nav">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home me-2"></i> Thống kê
        </a>

        <div class="nav-group">QUẢN LÝ</div>

        {{-- Người dùng --}}
        <div class="dropdown-item {{ $userOpen ? 'open' : '' }}">
            <div class="nav-link d-flex justify-content-between align-items-center toggle-next {{ $userOpen ? 'active' : '' }}">
                <span><i class="fas fa-users me-2"></i> Người dùng</span>
                <i class="fas fa-chevron-down small"></i>
            </div>
            <div class="sub-menu" style="{{ $userOpen ? 'display:block' : '' }}">
                <a href="{{ route('admin.user_list') }}"
                   class="{{ request()->routeIs('admin.user_list') ? 'active' : '' }}">
                    <i class="fas fa-list-ul me-2"></i> Danh sách
                </a>
            </div>
        </div>

        {{-- Danh mục --}}
        <div class="dropdown-item {{ $categoryOpen ? 'open' : '' }}">
            <div class="nav-link d-flex justify-content-between align-items-center toggle-next {{ $categoryOpen ? 'active' : '' }}">
                <span><i class="fas fa-th-large me-2"></i> Danh mục</span>
                <i class="fas fa-chevron-down small"></i>
            </div>
            <div class="sub-menu" style="{{ $categoryOpen ? 'display:block' : '' }}">
                <a href="{{ route('admin.categories.category_list') }}"
                   class="{{ request()->routeIs('admin.categories.category_list') ? 'active' : '' }}">
                    <i class="fas fa-list-ul me-2"></i> Danh sách
                </a>
                <a href="{{ route('admin.categories.add_category') }}"
                   class="{{ request()->routeIs('admin.categories.add_category') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle me-2"></i> Thêm mới
                </a>
            </div>
        </div>

        {{-- Sản phẩm --}}
        <div class="dropdown-item {{ $productOpen ? 'open' : '' }}">
            <div class="nav-link d-flex justify-content-between align-items-center toggle-next {{ $productOpen ? 'active' : '' }}">
                <span><i class="fas fa-box me-2"></i> Sản phẩm</span>
                <i class="fas fa-chevron-down small"></i>
            </div>
            <div class="sub-menu" style="{{ $productOpen ? 'display:block' : '' }}">
                <a href="{{ route('admin.products.product_list') }}"
                   class="{{ request()->routeIs('admin.products.product_list') ? 'active' : '' }}">
                    <i class="fas fa-list-ul me-2"></i> Danh sách
                </a>
                <a href="{{ route('admin.products.add_product') }}"
                   class="{{ request()->routeIs('admin.products.add_product') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle me-2"></i> Thêm mới
                </a>
            </div>
        </div>

        {{-- Đơn hàng --}}
        <a href="{{ route('admin.orders.orders') }}"
           class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag me-2"></i> Đơn hàng
        </a>

        <div class="nav-group">TÀI CHÍNH</div>

        {{-- Tài chính --}}
        <a href="{{ route('admin.finance.add_funds') }}"
           class="nav-link {{ request()->routeIs('admin.finance.add_funds') ? 'active' : '' }}">
            <i class="fas fa-plus-circle me-2"></i> Cộng tiền
        </a>

        <a href="{{ route('admin.finance.cashflow') }}"
           class="nav-link {{ request()->routeIs('admin.finance.cashflow') ? 'active' : '' }}">
            <i class="fas fa-chart-line me-2"></i> Dòng tiền
        </a>

        {{-- Quay lại client --}}
        <a href="{{ route('home') }}" class="nav-link text-danger mt-4">
            <i class="fas fa-sign-out-alt me-2"></i> Quay lại Website
        </a>
    </nav>
</div>
