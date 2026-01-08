document.addEventListener('DOMContentLoaded', function() {
    const iconInput = document.getElementById('catIcon');
    const fileInput = document.getElementById('catFile');
    const iconShow = document.getElementById('iconShow');
    const imageShow = document.getElementById('imageShow');
    const form = document.getElementById('addCategoryForm');
    const submitBtn = document.getElementById('submitBtnCat');

    // 1. Xử lý khi nhập Icon FontAwesome
    if (iconInput) {
        iconInput.addEventListener('input', function() {
            if (this.value.trim() !== "") {
                iconShow.className = this.value + " text-primary";
                iconShow.classList.remove('d-none');
                imageShow.classList.add('d-none');
                if(fileInput) fileInput.value = ""; 
            } else {
                iconShow.className = "fas fa-folder-plus text-primary";
            }
        });
    }

    // 2. Xử lý khi tải file ảnh (Xem trước)
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imageShow.src = e.target.result;
                    imageShow.classList.remove('d-none');
                    iconShow.classList.add('d-none');
                    if(iconInput) iconInput.value = "";
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // 3. Xử lý CHỐNG CLICK NHIỀU LẦN
    if (form) {
        form.addEventListener('submit', function(e) {
            // Kiểm tra nếu nút đang trong trạng thái disabled thì không cho submit
            if (submitBtn.disabled) {
                e.preventDefault();
                return false;
            }

            // Vô hiệu hóa nút bấm ngay lập tức
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Đang lưu...';
            submitBtn.style.opacity = '0.7';

            // Cho phép form gửi dữ liệu thật lên server Laravel
            return true;
        });
    }
});