document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('prodFile');
    const productImageShow = document.getElementById('productImageShow');
    const placeholderIcon = document.getElementById('placeholderIcon');
    const form = document.getElementById('addProductForm');
    const submitBtn = document.getElementById('submitBtn');

    // 1. Xử lý xem trước ảnh khi chọn file
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    productImageShow.src = e.target.result;
                    productImageShow.classList.remove('d-none');
                    placeholderIcon.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                productImageShow.classList.add('d-none');
                placeholderIcon.classList.remove('d-none');
            }
        });
    }

    // 2. Xử lý ngăn chặn Double Click (Click nhiều lần)
    if (form) {
        form.addEventListener('submit', function(e) {
            // Nếu nút đã bị vô hiệu hóa, ngăn không cho submit nữa
            if (submitBtn.disabled) {
                e.preventDefault();
                return false;
            }

            // Ngay lập tức vô hiệu hóa nút bấm
            submitBtn.disabled = true;
            
            // Thay đổi giao diện nút để báo hiệu cho người dùng
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...';
            submitBtn.style.opacity = '0.7';
            submitBtn.style.cursor = 'not-allowed';

            // Cho phép form gửi đi theo cách mặc định lên Laravel
            return true;
        });
    }
});