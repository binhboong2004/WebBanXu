// Dữ liệu giả lập đồng bộ với cashflow.js
const cashflowData = [
    { id: "TX-1001", customer: "Vũ Duy Bình", amount: "+500,000đ", type: "in", content: "Nạp tiền qua Techcombank", time: "25/12/2023 10:20", status: "Thành công", method: "Chuyển khoản" },
    { id: "TX-1002", customer: "Nguyễn Văn A", amount: "-75,000đ", type: "out", content: "Thanh toán đơn #ORD-99102", time: "25/12/2023 15:45", status: "Thành công", method: "Số dư tài khoản" },
    { id: "TX-1003", customer: "Trần Thị B", amount: "+200,000đ", type: "in", content: "Khuyến mãi nạp đầu", time: "25/12/2023 16:00", status: "Đã cộng", method: "Hệ thống" },
    { id: "TX-1004", customer: "Lê Văn C", amount: "-300,000đ", type: "out", content: "Mua Xu Trao Đổi Sub", time: "24/12/2023 09:00", status: "Hoàn tất", method: "Ví điện tử" }
];

function renderReceipt() {
    const urlParams = new URLSearchParams(window.location.search);
    const receiptId = urlParams.get('id');
    const container = document.getElementById('receiptContent');

    const data = cashflowData.find(item => item.id === receiptId);

    if (!data) {
        container.innerHTML = `
            <div class="p-5 text-center">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <p class="fw-bold">Không tìm thấy mã giao dịch: ${receiptId || 'Trống'}</p>
                <a href="/cashflow" class="btn btn-primary btn-sm px-4">Quay lại danh sách</a>
            </div>`;
        return;
    }

    // Xử lý màu sắc và biểu tượng dựa trên loại giao dịch
    const isPositive = data.type === 'in';
    const colorClass = isPositive ? 'text-success' : 'text-danger';
    const stampColor = isPositive ? '#22c55e' : '#ef4444';
    
    // Đảm bảo hiển thị đúng định dạng tiền tệ
    const displayAmount = typeof data.amount === 'number' 
        ? (isPositive ? '+' : '-') + data.amount.toLocaleString() + 'đ' 
        : data.amount;

    container.innerHTML = `
        <div class="receipt-header" style="background: ${isPositive ? '#4361ee' : '#1e293b'}">
            <h5 class="mb-1 fw-bold text-white">BIÊN LAI GIAO DỊCH</h5>
            <small class="text-white-50">Mã: ${data.id}</small>
        </div>
        
        <div class="receipt-body">
            <div class="text-center mb-4">
                <div class="receipt-label">Số tiền giao dịch</div>
                <div class="amount-big ${colorClass}">${displayAmount}</div>
                <div class="status-stamp" style="color: ${stampColor}; border-color: ${stampColor}">
                    ${data.status}
                </div>
            </div>

            <div class="receipt-info-group mt-5">
                <div class="receipt-row">
                    <span class="receipt-label"><i class="far fa-user me-2"></i>Khách hàng</span>
                    <span class="receipt-value">${data.customer}</span>
                </div>

                <div class="receipt-row">
                    <span class="receipt-label"><i class="far fa-clock me-2"></i>Thời gian</span>
                    <span class="receipt-value">${data.time}</span>
                </div>

                <div class="receipt-row">
                    <span class="receipt-label"><i class="fas fa-wallet me-2"></i>Hình thức</span>
                    <span class="receipt-value">${data.method || 'Mặc định'}</span>
                </div>

                <div class="receipt-row no-border">
                    <span class="receipt-label"><i class="far fa-comment-alt me-2"></i>Nội dung</span>
                    <span class="receipt-value text-end" style="max-width: 60%">${data.content}</span>
                </div>
            </div>

            <div class="mt-5 pt-4 text-center border-top">
                <img src="img/logo.png" style="height: 50px; object-fit: contain;" alt="Logo" onerror="this.src='https://via.placeholder.com/150x50?text=BinhXuTuDong'">
                <p class="smallest text-muted mt-2 fw-medium">Cảm ơn bạn đã sử dụng dịch vụ của BinhXuTuDong</p>
                <div class="text-muted" style="font-size: 10px;">Bản quyền thuộc về hệ thống BinhXuTuDong</div>
            </div>
        </div>
    `;
}

// Hàm xử lý Sidebar
function initSidebar() {
    const dropdownToggles = document.querySelectorAll('.toggle-next');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.closest('.dropdown-item');
            parent.classList.toggle('open');
            const arrow = this.querySelector('.fa-chevron-down');
            if (arrow) {
                arrow.style.transform = parent.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    renderReceipt();
    initSidebar();
});