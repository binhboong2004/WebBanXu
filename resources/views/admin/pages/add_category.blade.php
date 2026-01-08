@extends('layouts.admin')

@section('title', 'Thêm danh mục')

@section('content')
<main class="main-content">
    <header class="top-header">
        <div class="header-left">
            <h5 class="fw-bold mb-0">Tạo danh mục mới</h5>
        </div>
    </header>

    <div class="content-body">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="user-card card border-0 shadow-sm rounded-4 p-5">
                    {{-- QUAN TRỌNG: Thêm id="addCategoryForm" --}}
                    <form id="addCategoryForm" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-4">
                            <div class="preview-box mx-auto d-flex align-items-center justify-content-center bg-light rounded-circle mb-2" 
                                 style="width: 80px; height: 80px; font-size: 30px; overflow: hidden;">
                                <i id="iconShow" class="fas fa-folder-plus text-primary"></i>
                                <img id="imageShow" src="" class="d-none w-100 h-100" style="object-fit: cover;">
                            </div>
                            <p class="small text-muted fw-bold">XEM TRƯỚC HIỂN THỊ</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">TÊN DANH MỤC</label>
                            <input type="text" name="name" id="catTitle" class="form-control rounded-pill px-4" placeholder="VD: Facebook VIP" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">ICON (FONTAWESOME)</label>
                            <input type="text" name="icon" id="catIcon" class="form-control rounded-pill px-4" placeholder="fab fa-facebook">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">HOẶC TẢI HÌNH ẢNH</label>
                            <input type="file" name="image" id="catFile" class="form-control rounded-pill" accept="image/*">
                            <div class="form-text small">Nếu tải ảnh, icon sẽ bị ẩn đi.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">MÔ TẢ</label>
                            <textarea name="description" class="form-control rounded-4 px-4" rows="3" placeholder="Nhập mô tả ngắn..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">TRẠNG THÁI</label>
                            <select name="status" id="catStatus" class="form-select rounded-pill px-4">
                                <option value="1">Đang hoạt động</option>
                                <option value="0">Đang bảo trì</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.categories.category_list') }}" class="btn btn-light rounded-pill px-4">Quay lại</a>
                            {{-- Thêm ID cho nút submit --}}
                            <button type="submit" id="submitBtnCat" class="btn btn-primary rounded-pill px-5 shadow-sm">
                                <i class="fas fa-save me-2"></i>Lưu dữ liệu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection