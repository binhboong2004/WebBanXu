/**
 * Xử lý tìm kiếm đơn hàng trên giao diện (Client-side filtering)
 */
document.getElementById('orderSearch')?.addEventListener('input', function(e) {
    const keyword = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.order-card-item');
    
    cards.forEach(card => {
        const content = card.innerText.toLowerCase();
        card.style.display = content.includes(keyword) ? "block" : "none";
    });
});

/**
 * Xử lý Sidebar Dropdown
 */
function initSidebar() {
    const dropdownToggles = document.querySelectorAll('.toggle-next');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            
            // Toggle mở/đóng menu con
            parent.classList.toggle('open');
            
            // Xoay icon mũi tên
            const arrow = this.querySelector('.fa-chevron-down');
            if (arrow) {
                arrow.style.transform = parent.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', initSidebar);