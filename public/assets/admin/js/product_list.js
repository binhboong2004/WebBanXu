let productData = [
    {
        name: "Xu Trao Đổi Sub 1 Triệu Xu",
        category: "Trao Doi Sub",
        price: "150,000đ",
        stock: 45,
        image: "img/product-fb.png",
        isAvailable: true
    },
    {
        name: "Xu Tương Tác Chéo 1 Triệu Xu",
        category: "Tuong Tac Cheo",
        price: "350,000đ",
        stock: 12,
        image: "img/product-bm.png",
        isAvailable: true
    },
    {
        name: "Xu Tăng Like Chéo 1 Triệu Xu",
        category: "Tang Like Cheo",
        price: "5,000đ",
        stock: 0,
        image: "img/product-tiktok.png",
        isAvailable: false
    },
    {
        name: "Xu TikTok 20 Nghìn Xu",
        category: "Coin Tiktok",
        price: "2,500đ",
        stock: 1200,
        image: "img/product-gmail.png",
        isAvailable: true
    }
];

function renderProducts() {
    const container = document.getElementById('productContainer');
    if (!container) return;

    container.innerHTML = productData.map((product, index) => `
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="user-card">
                <div class="user-avatar-wrap">
                    <img src="${product.image}" class="user-avatar" alt="Product" 
                         onerror="this.src='https://via.placeholder.com/80?text=SP'">
                </div>
                <div class="user-name text-truncate" title="${product.name}">${product.name}</div>
                <span class="user-email text-primary fw-bold">${product.price}</span>
                
                <span class="role-badge ${product.isAvailable ? 'role-user' : 'role-admin'}">
                    ${product.category}
                </span>
                
                <div class="user-footer">
                    <div class="verify-status">
                        <span class="status-dot ${product.isAvailable && product.stock > 0 ? 'dot-green' : 'dot-red'}"></span>
                        <span class="text-muted small">${product.isAvailable ? 'Đang bán' : 'Dừng bán'} (Kho: ${product.stock})</span>
                    </div>

                    <div class="dropdown">
                        <div class="more-btn" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li>
                                <a class="dropdown-item small py-2" href="#" onclick="updateProductStatus(${index}, true)">
                                    <i class="fas fa-check-circle me-2 text-success"></i> Đang bán
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item small py-2" href="#" onclick="updateProductStatus(${index}, false)">
                                    <i class="fas fa-pause-circle me-2 text-warning"></i> Dừng bán
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item small py-2 text-danger" href="#" onclick="deleteProduct(${index})">
                                    <i class="fas fa-trash-alt me-2"></i> Xóa sản phẩm
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

// Hàm cập nhật trạng thái kinh doanh của sản phẩm
function updateProductStatus(index, status) {
    productData[index].isAvailable = status;
    renderProducts(); // Vẽ lại giao diện ngay lập tức
}

// Hàm xóa sản phẩm khỏi danh sách
function deleteProduct(index) {
    const productName = productData[index].name;
    if (confirm(`Bạn có chắc chắn muốn xóa sản phẩm "${productName}"?`)) {
        productData.splice(index, 1);
        renderProducts();
    }
}

// Logic Sidebar & Khởi tạo
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggles = document.querySelectorAll('.toggle-next');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            
            document.querySelectorAll('.dropdown-item').forEach(item => {
                if (item !== parent) item.classList.remove('open');
            });

            parent.classList.toggle('open');
            
            const arrow = this.querySelector('.fa-chevron-down');
            if (parent.classList.contains('open')) {
                arrow.style.transform = 'rotate(180deg)';
            } else {
                arrow.style.transform = 'rotate(0deg)';
            }
        });
    });

    renderProducts(); 
    const searchInput = document.getElementById('productSearch');
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const keyword = e.target.value.toLowerCase().trim();
            // Lấy tất cả các cột chứa Card sản phẩm
            const productCards = document.querySelectorAll('.col-xl-3.col-lg-4.col-md-6');

            productCards.forEach(card => {
                // Lấy toàn bộ văn bản bên trong card (tên, giá, xu)
                const cardText = card.innerText.toLowerCase();
                
                if (cardText.includes(keyword)) {
                    card.style.display = ""; // Hiển thị
                    card.classList.add('animated', 'fadeIn'); // Thêm hiệu ứng nếu có
                } else {
                    card.style.display = "none"; // Ẩn
                }
            });
            
            // Xử lý hiển thị thông báo nếu không tìm thấy kết quả
            checkEmptyResults();
        });
    }
});