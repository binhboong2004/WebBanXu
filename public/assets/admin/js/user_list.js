/**
 * user_list.js
 * Xử lý các tương tác tại trang danh sách người dùng
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Xử lý tìm kiếm nhanh (Client-side filtering)
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            const userCards = document.querySelectorAll('.user-card-item');

            userCards.forEach(card => {
                const name = card.querySelector('.user-name').textContent.toLowerCase();
                const email = card.querySelector('.user-email').textContent.toLowerCase();
                
                if (name.includes(value) || email.includes(value)) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            });
        });
    }

    // 2. Xử lý logic đóng/mở Sidebar Submenu (Nếu file sidebar.js riêng chưa có)
    const dropdownToggles = document.querySelectorAll('.toggle-next');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            
            // Xoay icon mũi tên
            const arrow = this.querySelector('.fa-chevron-down');
            
            if (parent.classList.contains('open')) {
                parent.classList.remove('open');
                if(arrow) arrow.style.transform = 'rotate(0deg)';
            } else {
                // Đóng các menu khác
                document.querySelectorAll('.dropdown-item').forEach(item => {
                    item.classList.remove('open');
                    const otherArrow = item.querySelector('.fa-chevron-down');
                    if(otherArrow) otherArrow.style.transform = 'rotate(0deg)';
                });

                parent.classList.add('open');
                if(arrow) {
                    arrow.style.transform = 'rotate(180deg)';
                    arrow.style.transition = '0.3s';
                }
            }
        });
    });
});