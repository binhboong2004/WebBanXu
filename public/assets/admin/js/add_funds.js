document.getElementById('addFundsForm')?.addEventListener('submit', function(e) {
    e.preventDefault();

    // Lấy giá trị từ form
    const userId = document.getElementById('user_id').value;
    const amount = document.getElementById('amount').value;
    const method = document.getElementById('method').value;
    const note = document.getElementById('note').value;

    // Lấy thời gian hiện tại chuẩn định dạng MySQL
    const now = new Date().toISOString().slice(0, 19).replace('T', ' ');

    // Tạo object mô phỏng một dòng trong bảng 'recharge_history'
    const newHistoryEntry = {
        id: "Tự động tăng",
        user_id: userId,
        amount: parseFloat(amount).toFixed(2),
        method: method,
        status: 1, // Trạng thái thành công
        created_at: now,
        updated_at: now
    };

    console.log("Dữ liệu gửi lên server:", newHistoryEntry);

    // Hiển thị thông báo (Phần này sau này bạn thay bằng gọi API PHP)
    alert(`Đã cộng ${amount}đ cho User ID ${userId} thành công!`);
    
    // Reset form sau khi gửi
    this.reset();
});