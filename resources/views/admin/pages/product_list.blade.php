@extends('layouts.admin')

@section('content')
<main class="main-content">
    <header class="top-header">
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="productSearch" placeholder="Tìm kiếm tên tài khoản, giá, hoặc xu...">
        </div>
        <div class="header-right">
            <div class="user-pill">
                <img src="{{ $admin->avatar ? asset('storage/'.$admin->avatar) : asset('assets/admin/img/avt.jpg') }}" alt="Admin">
                <span class="fw-bold small">{{ $admin->username }}</span>
            </div>
        </div>
    </header>

    <div class="content-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Quản lý tài khoản (Sản phẩm)</h4>
            <a href="{{ route('admin.products.add_product') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="fas fa-plus me-1"></i> Thêm tài khoản
            </a>
        </div>

        <div class="row g-3">
            @foreach($products as $item)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-2">
                    <div class="position-relative">
                        <img src="{{ $item->avatar ? asset('storage/'.$item->avatar) : 'https://via.placeholder.com/150' }}"
                            class="card-img-top rounded-4" style="height: 150px; object-fit: cover;">
                        <span class="position-absolute top-0 end-0 m-2 badge {{ $item->status == 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $item->status == 0 ? 'Đang bán' : 'Đã bán' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold mb-1 text-truncate">{{ $item->acc_username }}</h6>
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted">Giá: <b class="text-primary">{{ number_format($item->price) }}đ</b></span>
                            <span class="text-muted">Xu: <b class="text-warning">{{ number_format($item->xu_amount) }}</b></span>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.products.edit', $item->id) }}" class="btn btn-light btn-sm w-100 rounded-pill">Sửa</a>

                            {{-- Dropdown cho các thao tác khác --}}
                            <div class="dropup">
                                <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end animated fadeIn mb-2 shadow border-0">
                                    <form action="{{ route('admin.products.delete', $item->id) }}" method="POST" onsubmit="return confirm('Bạn muốn xóa tài khoản này?')">
                                        @csrf
                                        @method('DELETE') {{-- Giả lập phương thức DELETE --}}
                                        <button type="submit" class="dropdown-item text-danger small">
                                            <i class="fas fa-trash me-2"></i> Xóa sản phẩm
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->links() }} {{-- Hiển thị phân trang --}}
        </div>
    </div>
</main>
@endsection