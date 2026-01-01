document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('prodFile');
    const productImageShow = document.getElementById('productImageShow');
    const placeholderIcon = document.getElementById('placeholderIcon');
    const form = document.getElementById('addProductForm');

    // Xử lý xem trước ảnh khi chọn file
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

    // Xử lý lưu sản phẩm
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Định dạng tiền tệ đơn giản cho giá
        const priceValue = document.getElementById('prodPrice').value;
        const formattedPrice = new Intl.NumberFormat('vi-VN').format(priceValue) + "đ";

        const newProduct = {
            name: document.getElementById('prodName').value,
            category: document.getElementById('prodCategory').value,
            price: formattedPrice,
            stock: parseInt(document.getElementById('prodStock').value),
            image: productImageShow.classList.contains('d-none') ? "img/default-product.png" : productImageShow.src,
            isAvailable: document.getElementById('prodStatus').value === "true"
        };

        // Ghi log dữ liệu (Sau này sẽ thay bằng gọi API fetch/axios)
        console.log("Sản phẩm mới đã tạo:", newProduct);
        
        alert("Thêm sản phẩm thành công!");
        
        // Chuyển hướng về danh sách sản phẩm
        window.location.href = 'product_list.html';
    });

});