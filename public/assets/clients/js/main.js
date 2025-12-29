document.addEventListener('DOMContentLoaded', function () {
    // 1. Quản lý Modal Mua Hàng
    const modalElement = document.getElementById('confirmBuyModal');
    const buyModal = modalElement ? new bootstrap.Modal(modalElement) : null;

    // Tìm và sửa lại hàm openBuyModal trong main.js
    window.openBuyModal = function (name, price, qtyInputId) {
        const qtyInput = document.getElementById(qtyInputId);
        const quantity = qtyInput ? parseInt(qtyInput.value) : 1;
        const totalPrice = price * quantity;

        const nameDisplay = document.getElementById('modalProdName');
        const priceDisplay = document.getElementById('modalProdPrice');

        if (nameDisplay && priceDisplay) {
            // Hiển thị tên kèm số lượng
            nameDisplay.innerText = name + " (Số lượng: " + quantity + ")";

            // Định dạng tiền tệ VND khi hiển thị
            priceDisplay.innerText = new Intl.NumberFormat('vi-VN').format(totalPrice) + "đ";

            // Lưu thông tin tạm thời để xử lý mua (nếu cần)
            window.currentTransaction = {
                name: name,
                totalPrice: totalPrice,
                quantity: quantity
            };

            const modalElement = document.getElementById('confirmBuyModal');
            const buyModalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
            buyModalInstance.show();
        }
    };

    // Sửa lại submitPurchase để dùng Toast cho chuyên nghiệp
    window.submitPurchase = function () {
        const transaction = window.currentTransaction;
        const modalElement = document.getElementById('confirmBuyModal');
        const buyModalInstance = bootstrap.Modal.getInstance(modalElement);

        buyModalInstance.hide();

        // Hiển thị thông báo thành công (Hàm showToast đã có sẵn trong main.js của bạn)
        if (typeof showToast === "function") {
            showToast("Đang xử lý đơn hàng " + transaction.name + " số lượng " + transaction.quantity);
        } else {
            alert("Đang xử lý giao dịch...");
        }
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

    // 2. Thông báo khi nạp thẻ hoặc mua hàng (Toast thay vì Alert thô cứng)
    window.showToast = function (message, type = 'success') {
        const toastContainer = document.createElement('div');
        toastContainer.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 25px;
            background: ${type === 'success' ? '#28a745' : '#dc3545'};
            color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 9999;
            animation: fadeInUp 0.5s ease;
        `;
        toastContainer.innerText = message;
        document.body.appendChild(toastContainer);

        setTimeout(() => {
            toastContainer.style.opacity = '0';
            setTimeout(() => toastContainer.remove(), 500);
        }, 3000);
    };

    // Thay thế hàm submitPurchase cũ bằng showToast cho "xịn"
    const oldSubmit = window.submitPurchase;
    window.submitPurchase = function () {
        const prodName = document.getElementById('modalProdName').innerText;
        const buyModal = bootstrap.Modal.getInstance(document.getElementById('confirmBuyModal'));
        buyModal.hide();
        showToast("Đã mua thành công: " + prodName);
    };
});
