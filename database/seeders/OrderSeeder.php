<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Account;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy 1 user và 1 account đầu tiên để làm mẫu
        $user = User::first();
        $account = Account::first();

        if ($user && $account) {
            // Tạo 5 đơn hàng mẫu
            for ($i = 1; $i <= 5; $i++) {
                Order::create([
                    'user_id'     => $user->id,
                    'account_id'  => $account->id,
                    'total_price' => rand(10000, 50000), // Giá ngẫu nhiên để test
                ]);
            }
            $this->command->info('Đã tạo 5 đơn hàng mẫu thành công!');
        } else {
            $this->command->error('Chưa có User hoặc Account nào trong database để tạo Order!');
        }
    }
}