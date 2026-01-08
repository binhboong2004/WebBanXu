document.addEventListener('DOMContentLoaded', function() {
    const addFundsForm = document.getElementById('addFundsForm');
    const submitBtn = document.getElementById('submitBtnFunds');

    if (addFundsForm) {
        addFundsForm.addEventListener('submit', function(e) {
            
            // 1. Nếu nút đã bị vô hiệu hóa (đang xử lý), ngăn không cho click tiếp
            if (submitBtn.disabled) {
                e.preventDefault();
                return false;
            }

            // 2. Lấy giá trị để log (tùy chọn)
            const userId = document.getElementById('user_id').value;
            const amount = document.getElementById('amount').value;
            console.log(`Đang thực hiện nạp ${amount} cho User ID: ${userId}`);

            // 3. Vô hiệu hóa nút bấm ngay lập tức
            submitBtn.disabled = true;

            // 4. Thay đổi nội dung nút để người dùng chờ
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Đang xử lý nạp tiền...';
            submitBtn.classList.add('opacity-75');

            // Cho phép form gửi đi thực tế đến server
            return true;
        });
    }
});