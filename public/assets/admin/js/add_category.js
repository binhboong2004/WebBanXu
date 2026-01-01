document.addEventListener('DOMContentLoaded', function() {
    const iconInput = document.getElementById('catIcon');
    const fileInput = document.getElementById('catFile');
    const iconShow = document.getElementById('iconShow');
    const imageShow = document.getElementById('imageShow');
    const form = document.getElementById('addCategoryForm');

    // Xử lý khi nhập Icon FontAwesome
    iconInput.addEventListener('input', function() {
        if (this.value.trim() !== "") {
            // Hiển thị icon, ẩn ảnh
            iconShow.className = this.value;
            iconShow.classList.remove('d-none');
            imageShow.classList.add('d-none');
            // Xóa file đã chọn nếu có để tránh nhầm lẫn
            fileInput.value = ""; 
        } else {
            iconShow.className = "fas fa-folder-plus";
        }
    });

    // Xử lý khi tải file ảnh
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Hiển thị ảnh, ẩn icon
                imageShow.src = e.target.result;
                imageShow.classList.remove('d-none');
                iconShow.classList.add('d-none');
                // Xóa text icon đã nhập
                iconInput.value = "";
            }
            reader.readAsDataURL(file);
        }
    });

    // Xử lý nộp form
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const categoryInfo = {
            title: document.getElementById('catTitle').value,
            icon: iconInput.value || null,
            image: imageShow.classList.contains('d-none') ? null : imageShow.src,
            isActive: document.getElementById('catStatus').value === "true"
        };

        // Ở đây bạn sẽ gọi API để lưu vào database
        console.log("Dữ liệu gửi đi:", categoryInfo);
        
        alert("Thêm danh mục thành công!");
        window.location.href = 'category_list.html';
    });

});