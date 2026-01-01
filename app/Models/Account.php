<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'acc_username',
        'avatar',
        'acc_password',
        'xu_amount',
        'price',
        'status',
    ];

    protected $casts = [
        'xu_amount' => 'integer',
        'price' => 'decimal:2',
        'status' => 'integer', // 0: Đang bán, 1: Đã bán
    ];

    /**
     * Tài khoản thuộc về một danh mục (Ví dụ: Traodoisub)
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Một tài khoản khi bán xong sẽ gắn liền với một đơn hàng
     */
    public function order()
    {
        return $this->hasOne(Order::class, 'account_id', 'id');
    }

    protected static function booted()
    {
        // Khi thêm tài khoản mới, tăng số lượng trong Category
        static::created(function ($account) {
            if ($account->status == 0) {
                $account->category()->increment('total_accounts');
            }
        });

        // Quan trọng: Khi trạng thái tài khoản thay đổi (ví dụ từ 0 sang 1 khi mua)
        static::updated(function ($account) {
            if ($account->wasChanged('status')) {
                if ($account->status == 1) {
                    // Nếu chuyển sang trạng thái đã bán, giảm số lượng
                    $account->category()->decrement('total_accounts');
                } else if ($account->status == 0) {
                    // Nếu mở bán lại, tăng số lượng
                    $account->category()->increment('total_accounts');
                }
            }
        });

        // Khi xóa tài khoản
        static::deleted(function ($account) {
            if ($account->status == 0) {
                $account->category()->decrement('total_accounts');
            }
        });
    }
}
