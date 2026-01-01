document.addEventListener('DOMContentLoaded', function() {
    // 1. LOGIC ĐIỀU KHIỂN SIDEBAR (PHẦN BỊ THIẾU)
    const dropdownToggles = document.querySelectorAll('.toggle-next');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            
            // Đóng các dropdown khác
            document.querySelectorAll('.dropdown-item').forEach(item => {
                if (item !== parent) item.classList.remove('open');
            });

            // Toggle mở/đóng menu hiện tại
            parent.classList.toggle('open');
            
            // Xoay mũi tên
            const arrow = this.querySelector('.fa-chevron-down');
            if (arrow) {
                arrow.style.transform = parent.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    });

    // 2. LẤY DỮ LIỆU TỪ URL VÀ LOCALSTORAGE
    const urlParams = new URLSearchParams(window.location.search);
    const orderID = urlParams.get('id');
    let orders = JSON.parse(localStorage.getItem('my_orders_storage')) || [];
    const currentOrder = orders.find(o => o.id === orderID);

    // 3. HIỂN THỊ DỮ LIỆU LÊN GIAO DIỆN
    if (currentOrder) {
        document.getElementById('displayOrderID').innerText = currentOrder.id;
        document.getElementById('orderIDLabel').innerText = currentOrder.id;
        document.getElementById('prodName').innerText = currentOrder.product;
        document.getElementById('prodPrice').innerText = currentOrder.price;
        document.getElementById('orderTime').innerText = currentOrder.time || "25/12/2023 14:20";
        document.getElementById('cusName').innerText = currentOrder.customer;
        
        const statusTag = document.getElementById('orderStatus');
        if (statusTag) {
            statusTag.innerText = currentOrder.status;
            statusTag.className = `role-badge ${currentOrder.statusClass}`;
        }
    } else {
        // Nếu không tìm thấy đơn (ví dụ ID sai), báo lỗi
        console.error("Không tìm thấy đơn hàng!");
    }

    // 4. LOGIC XỬ LÝ XÓA ĐƠN HÀNG
    const btnDelete = document.getElementById('btnDeleteOrder');
    if (btnDelete) {
        btnDelete.addEventListener('click', function() {
            const isConfirm = confirm(`Bạn có chắc chắn muốn xóa đơn hàng ${orderID}?`);
            if (isConfirm) {
                const updatedOrders = orders.filter(o => o.id !== orderID);
                localStorage.setItem('my_orders_storage', JSON.stringify(updatedOrders));
                alert('Đã xóa đơn hàng thành công!');
                window.location.href = 'orders.html';
            }
        });
    }
});