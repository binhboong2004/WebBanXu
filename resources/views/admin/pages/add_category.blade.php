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
                    {{-- QUAN TRỌNG: enctype="multipart/form-data" để gửi file --}}
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-4">
                            <div class="preview-box mx-auto d-flex align-items-center justify-content-center bg-light rounded-circle mb-2" 
                                 style="width: 80px; height: 80px; font-size: 30px; overflow: hidden;">
                                {{-- Hiển thị Icon mặc định --}}
                                <i id="iconPreview" class="fas fa-folder-plus text-primary"></i>
                                {{-- Hiển thị Ảnh khi người dùng chọn file --}}
                                <img id="imagePreview" src="" class="d-none w-100 h-100" style="object-fit: cover;">
                            </div>
                            <p class="small text-muted fw-bold">XEM TRƯỚC HIỂN THỊ</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">TÊN DANH MỤC</label>
                            <input type="text" name="name" class="form-control rounded-pill px-4" placeholder="VD: Facebook VIP" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">ICON (FONTAWESOME)</label>
                            <input type="text" name="icon" id="iconInput" class="form-control rounded-pill px-4" placeholder="fab fa-facebook">
                        </div>

                        {{-- PHẦN THÊM MỚI: TẢI HÌNH ẢNH --}}
                        <div class="mb-3">
                            <label class="form-label small fw-bold">HOẶC TẢI HÌNH ẢNH</label>
                            <input type="file" name="image" id="imageInput" class="form-control rounded-pill" accept="image/*">
                            <div class="form-text small">Nếu tải ảnh, icon sẽ bị ẩn đi.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">MÔ TẢ</label>
                            <textarea name="description" class="form-control rounded-4 px-4" rows="3" placeholder="Nhập mô tả ngắn..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">TRẠNG THÁI</label>
                            <select name="status" class="form-select rounded-pill px-4">
                                <option value="1">Đang hoạt động</option>
                                <option value="0">Đang bảo trì</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.categories.category_list') }}" class="btn btn-light rounded-pill px-4">Quay lại</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">Lưu dữ liệu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    const iconInput = document.getElementById('iconInput');
    const imageInput = document.getElementById('imageInput');
    const iconPreview = document.getElementById('iconPreview');
    const imagePreview = document.getElementById('imagePreview');

    // Xử lý đổi Icon Preview
    iconInput.addEventListener('input', function() {
        if(this.value.trim() !== "") {
            imagePreview.classList.add('d-none'); // Ẩn ảnh
            iconPreview.classList.remove('d-none'); // Hiện icon
            iconPreview.className = this.value + " text-primary";
        }
    });

    // Xử lý xem trước Ảnh khi chọn file
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('d-none'); // Hiện ảnh
                iconPreview.classList.add('d-none'); // Ẩn icon
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection