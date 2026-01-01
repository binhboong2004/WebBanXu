@extends('layouts.admin')

@section('title', 'Danh sách danh mục')

@section('content')
<main class="main-content">
    <header class="top-header">
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchCategory" placeholder="Tìm kiếm danh mục theo tên...">
        </div>
        <div class="header-right">
            <div class="user-pill">
                <img src="{{ asset('assets/admin/img/avt.jpg') }}" alt="Admin">
                <span class="fw-bold small">{{ $admin->username ?? 'Admin' }}</span>
            </div>
        </div>
    </header>

    <div class="content-body">
        @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Quản lý danh mục</h4>
                <p class="text-muted small mb-0">Tổng cộng: <b>{{ $categories->count() }}</b> mục hiện có</p>
            </div>
            <a href="{{ route('admin.categories.add_category') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus me-1"></i> Thêm danh mục
            </a>
        </div>

        <div class="row g-4" id="categoryContainer">
            @forelse($categories as $cat)
            <div class="col-xl-3 col-lg-4 col-md-6 category-item">
                <div class="user-card card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                    {{-- PHẦN HIỂN THỊ ẢNH HOẶC ICON --}}
                    <div class="user-avatar-wrap d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; overflow: hidden;">
                        @if(!empty($cat->image))
                        {{-- Nếu có ảnh trong DB, hiển thị ảnh từ storage --}}
                        <img src="{{ asset('storage/' . $cat->image) }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                        {{-- Nếu không có ảnh, hiển thị Icon --}}
                        @php
                        $nameLower = strtolower($cat->name);
                        $icon = 'fas fa-folder text-primary';
                        if(str_contains($nameLower, 'facebook')) $icon = 'fab fa-facebook text-primary';
                        elseif(str_contains($nameLower, 'instagram')) $icon = 'fab fa-instagram text-danger';
                        elseif(str_contains($nameLower, 'gmail')) $icon = 'fas fa-envelope text-warning';
                        elseif(str_contains($nameLower, 'tiktok')) $icon = 'fab fa-tiktok text-dark';

                        if(!empty($cat->icon)) $icon = $cat->icon;
                        @endphp
                        <i class="{{ $icon }} fa-3x"></i>
                        @endif
                    </div>

                    <div class="user-name h5 fw-bold mb-1">{{ $cat->name }}</div>
                    <span class="user-email d-block text-muted small mb-3">Số lượng: {{ number_format($cat->real_total ?? 0) }} sản phẩm</span>

                    <span class="role-badge {{ ($cat->status ?? 1) == 1 ? 'role-user' : 'role-admin' }} mb-3 d-inline-block">
                        {{ ($cat->status ?? 1) == 1 ? 'Đang hoạt động' : 'Đang bảo trì' }}
                    </span>

                    <div class="user-footer d-flex justify-content-between align-items-center border-top pt-3">
                        <div class="verify-status">
                            <span class="status-dot {{ ($cat->status ?? 1) == 1 ? 'dot-green' : 'dot-red' }}"></span>
                            <span class="text-muted small">{{ ($cat->status ?? 1) == 1 ? 'Hoạt động' : 'Bảo trì' }}</span>
                        </div>

                        <div class="dropdown">
                            <div class="more-btn p-2" data-bs-toggle="dropdown" style="cursor: pointer;">
                                <i class="fas fa-ellipsis-v text-muted"></i>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li>
                                    <a class="dropdown-item small" href="{{ route('admin.categories.edit_category', $cat->id) }}">
                                        <i class="fas fa-edit me-2"></i>Sửa
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('admin.categories.delete_category', $cat->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item small text-danger border-0 bg-transparent w-100 text-start">
                                            <i class="fas fa-trash-alt me-2"></i>Xóa
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Chưa có danh mục nào.</p>
            </div>
            @endforelse
        </div>
    </div>
</main>
@endsection