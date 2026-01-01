document.addEventListener('DOMContentLoaded', function () {
    const dropdownToggles = document.querySelectorAll('.toggle-next');

    if (!dropdownToggles.length) return;

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();

            const parent = this.closest('.dropdown-item');

            document.querySelectorAll('.dropdown-item').forEach(item => {
                if (item !== parent) item.classList.remove('open');
            });

            parent.classList.toggle('open');

            const arrow = this.querySelector('.fa-chevron-down');
            if (arrow) {
                arrow.style.transform = parent.classList.contains('open')
                    ? 'rotate(180deg)'
                    : 'rotate(0deg)';
            }
        });
    });
});
