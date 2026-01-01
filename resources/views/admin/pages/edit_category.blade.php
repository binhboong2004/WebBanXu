@extends('layouts.admin')

@section('title', 'Chỉnh sửa danh mục')

@section('content')
<main class="main-content">
    <header class="top-header">
        <div class="header-left">
            <h5 class="fw-bold mb-0">Chỉnh sửa: {{ $category->name }}</h5>
        </div>
    </header>

    <div class="content-body">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="user-card card border-0 shadow-sm rounded-4 p-5">
                    <form action="{{ route('admin.categories.update_category', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-4">
                            <div class="preview-box mx-auto d-flex align-items-center justify-content-center bg-light rounded-circle mb-2" 
                                 style="width: 80px; height: 80px; font-size: 30px; overflow: hidden;">
                                
                                @if($category->image)
                                    <img id="imagePreview" src="{{ asset('storage/' . $category->image) }}" class="w-100 h-100" style="object-fit: cover;">
                                    <i id="iconPreview" class="d-none"></i>
                                @else
                                    <i id="iconPreview" class="{{ $category->icon ?? 'fas fa-folder' }} text-primary"></i>
                                    <img id="imagePreview" src="" class="d-none w-100 h-100" style="object-fit: cover;">
                                @endif
                            </div>
                            <p class="small text-muted fw-bold">XEM TRƯỚC HIỂN THỊ</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">TÊN DANH MỤC</label>
                            <input type="text" name="name" class="form-control rounded-pill px-4" value="{{ $category->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">ICON (FONTAWESOME)</label>
                            <input type="text" name="icon" id="iconInput" class="form-control rounded-pill px-4" value="{{ $category->icon }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">THAY ĐỔI HÌNH ẢNH</label>
                            <input type="file" name="image" id="imageInput" class="form-control rounded-pill" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">MÔ TẢ</label>
                            <textarea name="description" class="form-control rounded-4 px-4" rows="3">{{ $category->description }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">TRẠNG THÁI</label>
                            <select name="status" class="form-select rounded-pill px-4">
                                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Đang hoạt động</option>
                                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Đang bảo trì</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.categories.category_list') }}" class="btn btn-light rounded-pill px-4">Hủy</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">Cập nhật ngay</button>
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

    iconInput.addEventListener('input', function() {
        if(this.value.trim() !== "") {
            imagePreview.classList.add('d-none');
            iconPreview.classList.remove('d-none');
            iconPreview.className = this.value + " text-primary";
        }
    });

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('d-none');
                iconPreview.classList.add('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection