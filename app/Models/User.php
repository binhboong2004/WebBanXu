<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Các trường có thể nhập dữ liệu hàng loạt (Mass Assignment)
     * Phải khớp với các cột bạn đã tạo trong Migration
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'avatar',
        'full_name',
        'balance',
        'total_deposit',
        'role',
        'status',
        'token',
    ];

    /**
     * Các trường cần ẩn khi chuyển sang dạng mảng hoặc JSON (Bảo mật)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Thiết lập kiểu dữ liệu cho các cột (Casting)
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'balance' => 'decimal:2', // Đảm bảo số dư luôn là dạng số thập phân
    ];

    // =========================================================================
    // THIẾT LẬP CÁC MỐI QUAN HỆ (RELATIONSHIPS) THEO SƠ ĐỒ DATABASE
    // =========================================================================

    /**
     * Một User có nhiều Lịch sử nạp tiền (Use Case: Lịch sử nạp tiền)
     */
    public function rechargeHistories()
    {
        return $this->hasMany(RechargeHistory::class, 'user_id', 'id');
    }

    /**
     * Một User có nhiều Đơn hàng mua tài khoản (Use Case: Lịch sử tài khoản đã mua)
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function getAvatarUrlAttribute(){
        return $this->avatar ? asset('storage/' . $this->avatar) : asset('storage/uploads/users/default-avatar.png');
    }
}