<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'avatar',
        'total_accounts',
    ];

    /**
     * Một danh mục có nhiều tài khoản (Use Case: Xem, lọc sản phẩm)
     */
    public function accounts()
    {
        return $this->hasMany(Account::class, 'category_id', 'id');
    }

    // Hàm này giúp lấy số lượng tài khoản đang bán (status = 0)
    public function getAvailableAccountsCountAttribute()
    {
        return $this->accounts()->where('status', 0)->count();
    }
}
