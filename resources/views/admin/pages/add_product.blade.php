@extends('layouts.admin')

@section('title', 'Thêm sản phẩm mới')

@section('content')
<main class="main-content">
    <header class="top-header">
        <div class="header-left">
            <h5 class="fw-bold mb-0">Thêm Sản Phẩm Mới</h5>
        </div>
        <div class="header-right">
            <div class="user-pill">
                <img src="{{ $admin->avatar ? asset('storage/'.$admin->avatar) : asset('assets/admin/img/avt.jpg') }}" alt="Admin">
                <span class="fw-bold small">{{ $admin->username }}</span>
            </div>
        </div>
    </header>

    <div class="content-body">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm p-4 rounded-4">
                    {{-- CHỈ DUY NHẤT 1 THẺ FORM CÓ ID --}}
                    <form id="addProductForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Phần Preview Ảnh --}}
                        <div class="text-center mb-4">
                            <div class="product-preview-box mb-2 mx-auto" id="previewContainer" 
                                 style="width: 160px; height: 160px; border: 2px dashed #cbd5e0; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 20px; background-color: #f8fafc;">
                                <i id="placeholderIcon" class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                <img id="productImageShow" src="" class="d-none w-100 h-100" style="object-fit: cover;">
                            </div>
                            <span class="small text-muted fw-bold text-uppercase">Hình đại diện tài khoản</span>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">TÊN TÀI KHOẢN (Username)</label>
                                <input type="text" name="acc_username" class="form-control rounded-pill px-4 shadow-none border-light bg-light" placeholder="VD: nick_test_01" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">MẬT KHẨU (Password)</label>
                                <input type="text" name="acc_password" class="form-control rounded-pill px-4 shadow-none border-light bg-light" placeholder="Nhập mật khẩu" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">DANH MỤC SẢN PHẨM</label>
                                <select name="category_id" class="form-select rounded-pill px-4 shadow-none border-light bg-light" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">TẢI ẢNH SẢN PHẨM</label>
                                <input type="file" name="avatar" class="form-control rounded-pill shadow-none border-light bg-light" id="prodFile" accept="image/*">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">GIÁ BÁN (VNĐ)</label>
                                <div class="input-group">
                                    <input type="number" name="price" class="form-control rounded-start-pill px-4 shadow-none border-light bg-light" placeholder="20000" required>
                                    <span class="input-group-text rounded-end-pill bg-light border-light text-muted fw-bold">₫</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">SỐ XU TRONG TÀI KHOẢN</label>
                                <input type="number" name="xu_amount" class="form-control rounded-pill px-4 shadow-none border-light bg-light" placeholder="500000" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">TRẠNG THÁI HIỂN THỊ</label>
                                <select name="status" class="form-select rounded-pill px-4 shadow-none border-light bg-light">
                                    <option value="0">Đang bán (Hiển thị trên Web)</option>
                                    <option value="1">Ngừng bán / Đã bán (Ẩn khỏi Web)</option>
                                </select>
                            </div>
                        </div>

                        {{-- Nút điều hướng - Nằm trong cùng 1 thẻ form --}}
                        <div class="d-flex gap-3 justify-content-end mt-5">
                            <a href="{{ route('admin.products.product_list') }}" class="btn btn-light rounded-pill px-4 fw-bold border">
                                <i class="fas fa-times me-2"></i>Hủy bỏ
                            </a>
                            <button type="submit" id="submitBtn" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i>Lưu sản phẩm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection