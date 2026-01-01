@extends('layouts.admin')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
<main class="main-content">
    <header class="top-header">
        <div class="header-left">
            <h5 class="fw-bold mb-0">Chỉnh Sửa Sản Phẩm</h5>
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
                    {{-- Form cập nhật sản phẩm --}}
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Phần Preview Ảnh Hiện Tại --}}
                        <div class="text-center mb-4">
                            <div class="product-preview-box mb-2 mx-auto" id="previewContainer" 
                                 style="width: 160px; height: 160px; border: 2px dashed #cbd5e0; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 20px; background-color: #f8fafc;">
                                {{-- Nếu có ảnh cũ thì hiện ảnh cũ, không thì hiện icon --}}
                                <img id="productImageShow" 
                                     src="{{ $product->avatar ? asset('storage/'.$product->avatar) : '' }}" 
                                     class="{{ $product->avatar ? '' : 'd-none' }} w-100 h-100" 
                                     style="object-fit: cover;">
                                <i id="placeholderIcon" class="fas fa-cloud-upload-alt fa-3x text-muted {{ $product->avatar ? 'd-none' : '' }}"></i>
                            </div>
                            <span class="small text-muted fw-bold text-uppercase">Ảnh sản phẩm hiện tại</span>
                        </div>

                        <div class="row g-4">
                            {{-- Tên tài khoản --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">TÊN TÀI KHOẢN (Username)</label>
                                <input type="text" name="acc_username" value="{{ $product->acc_username }}" 
                                       class="form-control rounded-pill px-4 shadow-none border-light bg-light" required>
                            </div>

                            {{-- Mật khẩu --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">MẬT KHẨU (Password)</label>
                                <input type="text" name="acc_password" value="{{ $product->acc_password }}" 
                                       class="form-control rounded-pill px-4 shadow-none border-light bg-light" required>
                            </div>

                            {{-- Danh mục --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">DANH MỤC SẢN PHẨM</label>
                                <select name="category_id" class="form-select rounded-pill px-4 shadow-none border-light bg-light" required>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Thay đổi ảnh --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">THAY ĐỔI ẢNH (Bỏ trống nếu giữ nguyên)</label>
                                <input type="file" name="avatar" class="form-control rounded-pill shadow-none border-light bg-light" 
                                       id="prodFile" accept="image/*" onchange="previewImage(this)">
                            </div>

                            {{-- Giá bán --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">GIÁ BÁN (VNĐ)</label>
                                <div class="input-group">
                                    <input type="number" name="price" value="{{ (int)$product->price }}" 
                                           class="form-control rounded-start-pill px-4 shadow-none border-light bg-light" required>
                                    <span class="input-group-text rounded-end-pill bg-light border-light text-muted fw-bold">₫</span>
                                </div>
                            </div>

                            {{-- Số lượng Xu --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">SỐ XU TRONG TÀI KHOẢN</label>
                                <input type="number" name="xu_amount" value="{{ $product->xu_amount }}" 
                                       class="form-control rounded-pill px-4 shadow-none border-light bg-light" required>
                            </div>

                            {{-- Trạng thái --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">TRẠNG THÁI HIỂN THỊ</label>
                                <select name="status" class="form-select rounded-pill px-4 shadow-none border-light bg-light">
                                    <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Đang bán</option>
                                    <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Ngừng bán / Đã bán</option>
                                </select>
                            </div>
                        </div>

                        {{-- Nút điều hướng --}}
                        <div class="d-flex gap-3 justify-content-end mt-5">
                            <a href="{{ route('admin.products.product_list') }}" class="btn btn-light rounded-pill px-4 fw-bold border">
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                <i class="fas fa-sync-alt me-2"></i>Cập nhật ngay
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('productImageShow');
            const icon = document.getElementById('placeholderIcon');
            img.src = e.target.result;
            img.classList.remove('d-none');
            icon.classList.add('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection