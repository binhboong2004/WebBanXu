<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RechargeHistory extends Model
{
    use HasFactory;

    // Chỉ định tên bảng nếu bạn đặt tên Migration là số ít hoặc khác chuẩn số nhiều
    protected $table = 'recharge_history'; 

    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'status',
        'transaction_note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'status' => 'integer', // 0: Chờ duyệt, 1: Thành công
    ];

    /**
     * Lịch sử nạp tiền thuộc về một người dùng (Use Case: Lịch sử nạp tiền)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}