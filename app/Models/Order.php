<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'account_id',
        'total_price',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * Đơn hàng thuộc về một người mua (Use Case: Lịch sử tài khoản đã mua)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Đơn hàng chứa thông tin tài khoản đã bán
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    protected static function booted()
{
    static::creating(function ($order) {
        // Tự động tạo mã dạng ORD + 6 ký tự ngẫu nhiên viết hoa (VD: ORD7F2A9X)
        $order->order_number = 'ORD' . strtoupper(\Illuminate\Support\Str::random(6));
    });
}
}