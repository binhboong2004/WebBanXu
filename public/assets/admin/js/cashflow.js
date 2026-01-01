const cashflowData = [
    {
        id: "TX-1001",
        customer: "Vũ Duy Bình",
        amount: "+500,000đ",
        type: "in", // Nạp tiền
        content: "Nạp tiền qua Techcombank",
        time: "25/12/2023 10:20",
        status: "Thành công"
    },
    {
        id: "TX-1002",
        customer: "Nguyễn Văn A",
        amount: "-75,000đ",
        type: "out", // Thanh toán
        content: "Thanh toán đơn #ORD-99102",
        time: "25/12/2023 15:45",
        status: "Thành công"
    },
    {
        id: "TX-1003",
        customer: "Trần Thị B",
        amount: "+200,000đ",
        type: "in",
        content: "Khuyến mãi nạp đầu",
        time: "25/12/2023 16:00",
        status: "Đã cộng"
    },
    {
        id: "TX-1004",
        customer: "Lê Văn C",
        amount: "-300,000đ",
        type: "out",
        content: "Mua Xu Trao Đổi Sub",
        time: "24/12/2023 09:00",
        status: "Hoàn tất"
    }
];

function renderCashflow() {
    const container = document.getElementById('cashflowContainer');
    if (!container) return;

    // Tính toán tổng thu/chi ảo
    let tin = 0, tout = 0;
    cashflowData.forEach(item => {
        if(item.type === 'in') tin++; else tout++;
    });
    document.getElementById('totalIn').innerText = tin + " giao dịch cộng";
    document.getElementById('totalOut').innerText = tout + " giao dịch trừ";

    container.innerHTML = cashflowData.map((item, index) => `
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="user-card">
                <div class="user-avatar-wrap d-flex align-items-center justify-content-center ${item.type === 'in' ? 'bg-success-subtle' : 'bg-danger-subtle'} rounded-circle shadow-sm">
                    <i class="fas ${item.type === 'in' ? 'fa-arrow-up text-success' : 'fa-arrow-down text-danger'} fa-2x"></i>
                </div>
                
                <div class="user-name text-truncate mt-2">${item.id}</div>
                <div class="user-email mb-3">${item.time}</div>
                
                <div class="fw-bold ${item.type === 'in' ? 'text-success' : 'text-danger'} fs-5 mb-1">${item.amount}</div>
                <div class="small text-muted text-truncate px-2 mb-3" title="${item.content}">
                    ${item.content}
                </div>
                
                <span class="role-badge ${item.type === 'in' ? 'role-user' : 'role-admin'}">
                    ${item.status}
                </span>
                
                <div class="user-footer mt-4">
                    <div class="verify-status">
                        <i class="fas fa-user-circle text-muted"></i>
                        <span class="text-dark fw-medium small">${item.customer}</span>
                    </div>
                    <div class="dropdown">
                        <div class="more-btn" data-bs-toggle="dropdown" style="cursor: pointer;">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                            <li><a class="dropdown-item small" href="receipt_detail.html?id=${item.id}"><i class="fas fa-file-invoice-dollar me-2"></i> Xem biên lai</a></li>
                            <li><a class="dropdown-item small text-danger" href="#" onclick="deleteLog(${index})"><i class="fas fa-trash me-2"></i> Xóa log</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

function deleteLog(index) {
    if(confirm('Xóa lịch sử giao dịch này?')) {
        cashflowData.splice(index, 1);
        renderCashflow();
    }
}

// Tìm kiếm dòng tiền
document.getElementById('cashflowSearch')?.addEventListener('input', function(e) {
    const keyword = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('#cashflowContainer > div');
    
    cards.forEach(card => {
        const content = card.innerText.toLowerCase();
        card.style.display = content.includes(keyword) ? "block" : "none";
    });
});

// Khởi tạo Sidebar (đã sửa class sidebar-dropdown để tránh xung đột)
function initSidebar() {
    const dropdownToggles = document.querySelectorAll('.toggle-next');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.closest('.sidebar-dropdown');
            if(!parent) return;

            document.querySelectorAll('.sidebar-dropdown').forEach(item => {
                if (item !== parent) item.classList.remove('open');
            });

            parent.classList.toggle('open');
            const arrow = this.querySelector('.fa-chevron-down');
            if (arrow) {
                arrow.style.transform = parent.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    renderCashflow();
    initSidebar();
});

function initSidebar() {
    const dropdownToggles = document.querySelectorAll('.toggle-next');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            
            // Đóng các dropdown khác đang mở (nếu muốn)
            document.querySelectorAll('.dropdown-item').forEach(item => {
                if (item !== parent) item.classList.remove('open');
            });

            // Toggle class open cho item hiện tại
            parent.classList.toggle('open');
            
            // Xử lý xoay mũi tên (nếu có i tag chevron)
            const arrow = this.querySelector('.fa-chevron-down');
            if (arrow) {
                if (parent.classList.contains('open')) {
                    arrow.style.transform = 'rotate(180deg)';
                } else {
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
        });
    });
}