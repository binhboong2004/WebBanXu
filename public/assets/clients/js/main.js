window.showToast = function (message, type = 'success') {
    // Xóa toast cũ nếu có để tránh chồng chéo
    const oldToast = document.querySelector('.custom-toast');
    if (oldToast) oldToast.remove();

    const toast = document.createElement('div');
    toast.className = `custom-toast ${type}`;
    
    // Chọn icon phù hợp
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    const bgColor = type === 'success' ? '#2ecc71' : '#e74c3c';

    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        min-width: 300px;
        background: white;
        color: #333;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        z-index: 10000;
        display: flex;
        align-items: center;
        gap: 12px;
        border-left: 5px solid ${bgColor};
        transform: translateX(120%);
        transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    `;

    toast.innerHTML = `
        <div style="color: ${bgColor}; font-size: 24px;">
            <i class="fas ${icon}"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-weight: bold; color: #2c3e50;">Thông báo hệ thống</div>
            <div style="font-size: 14px; color: #7f8c8d;">${message}</div>
        </div>
        <div class="toast-progress" style="
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 100%;
            background: rgba(0,0,0,0.05);
        ">
            <div style="
                height: 100%;
                width: 100%;
                background: ${bgColor};
                animation: toastProgress 3s linear forwards;
            "></div>
        </div>
    `;

    document.body.appendChild(toast);

    // Thêm keyframe cho thanh tiến trình nếu chưa có
    if (!document.getElementById('toast-styles')) {
        const style = document.createElement('style');
        style.id = 'toast-styles';
        style.innerHTML = `
            @keyframes toastProgress {
                from { width: 100%; }
                to { width: 0%; }
            }
        `;
        document.head.appendChild(style);
    }

    // Hiển thị toast
    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
    }, 100);

    // Tự động đóng
    setTimeout(() => {
        toast.style.transform = 'translateX(120%)';
        setTimeout(() => toast.remove(), 500);
    }, 3000);
};

document.addEventListener('DOMContentLoaded', function () {
    // 1. Quản lý Modal Mua Hàng
    const modalElement = document.getElementById('confirmBuyModal');
    const buyModal = modalElement ? new bootstrap.Modal(modalElement) : null;

    // Tìm và sửa lại hàm openBuyModal trong main.js
    // 1. Hàm mở Modal và lưu trữ thông tin sản phẩm
    window.openBuyModal = function (name, price, qtyInputId, categoryId, xuAmount) {
        const qtyInput = document.getElementById(qtyInputId);
        const quantity = parseInt(qtyInput.value) || 1;
        const totalPrice = price * quantity;

        // Hiển thị lên Modal
        document.getElementById('modalProdName').innerText = name + " (Số lượng: " + quantity + ")";
        document.getElementById('modalProdPrice').innerText = new Intl.NumberFormat('vi-VN').format(totalPrice) + "đ";

        // Lưu biến tạm để gửi lên server
        window.currentBuyData = {
            category_id: categoryId,
            xu_amount: xuAmount,
            quantity: quantity
        };

        bootstrap.Modal.getOrCreateInstance(document.getElementById('confirmBuyModal')).show();
    };

    // 2. Hàm gửi yêu cầu mua hàng
    window.submitPurchase = function () {
        const btn = event.target;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> ĐANG XỬ LÝ...';

        $.ajax({
            url: '/buy-account',
            method: 'POST', // Đổi type thành method cho chắc chắn
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                category_id: window.currentBuyData.category_id,
                xu_amount: window.currentBuyData.xu_amount,
                quantity: window.currentBuyData.quantity
            },
            success: function (res) {
                if (res.success) {
                    if (typeof showToast === "function") showToast(res.message, 'success');
                    setTimeout(() => { location.reload(); }, 1500);
                } else {
                    if (typeof showToast === "function") showToast(res.message, 'error');
                    btn.disabled = false;
                    btn.innerText = 'XÁC NHẬN MUA';
                }
            },
            error: function (xhr) {
                console.error("Lỗi chi tiết:", xhr.responseText);
                if (typeof showToast === "function") showToast('Lỗi kết nối hoặc phiên đăng nhập hết hạn', 'error');
                btn.disabled = false;
                btn.innerText = 'XÁC NHẬN MUA';
            }
        });
    };

    // 2. XỬ LÝ LỖI HOVER: Menu biến mất khi di chuyển chuột
    const userInfoDropdown = document.querySelector('.user-info.dropdown');
    let timeout;

    if (userInfoDropdown) {
        const dropdownToggle = userInfoDropdown.querySelector('[data-bs-toggle="dropdown"]');
        const dropdownInstance = bootstrap.Dropdown.getOrCreateInstance(dropdownToggle);

        userInfoDropdown.addEventListener('mouseenter', function () {
            clearTimeout(timeout); // Hủy lệnh đóng nếu đang chờ
            dropdownInstance.show();
        });

        userInfoDropdown.addEventListener('mouseleave', function () {
            // Đợi 200ms trước khi đóng để người dùng kịp di chuyển chuột vào menu
            timeout = setTimeout(() => {
                dropdownInstance.hide();
            }, 200);
        });

        // Nếu chuột đang ở trong menu thì không đóng
        const menu = userInfoDropdown.querySelector('.dropdown-menu');
        menu.addEventListener('mouseenter', () => clearTimeout(timeout));
        menu.addEventListener('mouseleave', () => {
            timeout = setTimeout(() => {
                dropdownInstance.hide();
            }, 200);
        });
    }
});

let buyModal = new bootstrap.Modal(document.getElementById('confirmBuyModal'));

// --- HÀM LỌC SẢN PHẨM ---
function filterProduct(category, btnElement) {
    const items = document.querySelectorAll('.product-item');

    // 1. Lọc các dòng trong bảng
    items.forEach(item => {
        if (category === 'all') {
            item.style.display = ''; // Hiện tất cả
        } else {
            // Nếu data-category trùng với loại được chọn thì hiện, ngược lại ẩn
            item.style.display = (item.getAttribute('data-category') === category) ? '' : 'none';
        }
    });

    // 2. Cập nhật trạng thái nút bấm (Active)
    const buttons = document.querySelectorAll('#filter-buttons .btn');
    buttons.forEach(btn => {
        btn.classList.replace('btn-dark', 'btn-outline-dark');
    });
    btnElement.classList.replace('btn-outline-dark', 'btn-dark');
}

// --- HÀM MUA HÀNG ---
function openBuyModal(name, price) {
    document.getElementById('modalProdName').innerText = name;
    document.getElementById('modalProdPrice').innerText = price + "đ";
    buyModal.show();
}

function submitPurchase() {
    buyModal.hide();
    alert("Đang xử lý giao dịch. Vui lòng đợi...");
}

// Hàm đổ dữ liệu vào Modal khi bấm nút
function showAccount(user, pass) {
    document.getElementById('accContent').value = user + " | " + pass;
}

// Hàm copy thông tin vào bộ nhớ tạm
function copyToClipboard() {
    var copyText = document.getElementById("accContent");
    copyText.select();
    copyText.setSelectionRange(0, 99999); // Cho thiết bị di động
    navigator.clipboard.writeText(copyText.value);

    alert("Đã sao chép tài khoản: " + copyText.value);
}

// --- LOGIC ĐỔI AVATAR ---
const avatarInput = document.getElementById('avatarInput');
const userAvatarMain = document.getElementById('userAvatarMain'); // Ảnh lớn ở trang profile
const navAvatar = document.querySelector('.user-info img'); // Ảnh nhỏ ở thanh menu

if (avatarInput) {
    avatarInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            // Kiểm tra định dạng ảnh
            if (!file.type.startsWith('image/')) {
                alert('Vui lòng chọn tệp hình ảnh!');
                return;
            }

            // Tạo đường dẫn tạm thời để xem trước
            const reader = new FileReader();
            reader.onload = function (event) {
                // Cập nhật ảnh ở trang cá nhân
                if (userAvatarMain) userAvatarMain.src = event.target.result;
                // Cập nhật luôn ảnh ở thanh Navbar
                if (navAvatar) navAvatar.src = event.target.result;

                alert('Tải ảnh lên thành công! (Đây là bản xem trước)');
            };
            reader.readAsDataURL(file);
        }
    });
}

// Thêm xử lý nhỏ cho form đổi mật khẩu
document.getElementById('changePassForm').addEventListener('submit', function (e) {
    e.preventDefault();
    alert('Yêu cầu đổi mật khẩu đã được gửi! Hệ thống đang xử lý.');
});

document.addEventListener('DOMContentLoaded', function () {
    // 1. Hiệu ứng gợn sóng (Ripple) khi click vào nút bấm
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function (e) {
            let x = e.clientX - e.target.offsetLeft;
            let y = e.clientY - e.target.offsetTop;

            let ripples = document.createElement('span');
            ripples.style.left = x + 'px';
            ripples.style.top = y + 'px';
            this.appendChild(ripples);

            setTimeout(() => { ripples.remove() }, 1000);
        });
    });


    const oldSubmit = window.submitPurchase;
    window.submitPurchase = function () {
        const btn = event.target;
        const originalText = btn.innerText;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> ĐANG XỬ LÝ...';

        $.ajax({
            url: '/buy-account',
            type: 'POST',
            data: {
                ...window.currentBuyData,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                if (res.success) {
                    // Kiểm tra xem showToast có tồn tại trước khi gọi để tránh lỗi vỡ code
                    if (typeof showToast === "function") {
                        showToast(res.message, 'success');
                    } else {
                        alert(res.message);
                    }

                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (typeof showToast === "function") {
                        showToast(res.message, 'error');
                    } else {
                        alert(res.message);
                    }
                    btn.disabled = false;
                    btn.innerText = originalText;
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                if (typeof showToast === "function") {
                    showToast('Có lỗi xảy ra, vui lòng thử lại!', 'error');
                }
                btn.disabled = false;
                btn.innerText = originalText;
            }
        });
    };
});


