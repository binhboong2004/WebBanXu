document.addEventListener('DOMContentLoaded', function() {
    // 1. Xử lý Sidebar Dropdown (Giữ lại logic này)
    const dropdownToggles = document.querySelectorAll('.toggle-next');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            parent.classList.toggle('open');
            const arrow = this.querySelector('.fa-chevron-down');
            if (arrow) {
                arrow.style.transform = parent.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    });

    // 2. Xử lý Tìm kiếm nhanh (Search)
    const searchInput = document.getElementById('searchCategory');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const keyword = e.target.value.toLowerCase().trim();
            const items = document.querySelectorAll('.category-item');

            items.forEach(item => {
                const title = item.querySelector('.user-name').innerText.toLowerCase();
                item.style.display = title.includes(keyword) ? 'block' : 'none';
            });
        });
    }
});