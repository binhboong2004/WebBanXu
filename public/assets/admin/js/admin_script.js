document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('mainChart');
    
    // Nếu không tồn tại canvas (ở trang khác) thì dừng
    if (!canvas) return;

    // Lấy dữ liệu từ data-attributes đã đổ từ Blade
    const labels = JSON.parse(canvas.dataset.labels);
    const orders = JSON.parse(canvas.dataset.orders);
    const users = JSON.parse(canvas.dataset.users);

    const ctx = canvas.getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Đơn hàng',
                data: orders,
                backgroundColor: '#4361ee',
                borderRadius: 5,
                barThickness: 15
            }, {
                label: 'Thành viên mới',
                data: users,
                backgroundColor: '#adc1ff',
                borderRadius: 5,
                barThickness: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { 
                    display: true, 
                    position: 'bottom',
                    labels: { boxWidth: 12, font: { size: 11 } }
                } 
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 } } }
            }
        }
    });
});