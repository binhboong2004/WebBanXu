<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Account;
use App\Models\RechargeHistory;
use App\Models\Order; // Thêm dòng này
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa dữ liệu cũ để tránh lỗi Duplicate entry khi seed lại nhiều lần
        // Chỉ nên dùng lệnh này nếu bạn muốn làm sạch db mỗi khi seed
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Category::truncate();
        Account::truncate();
        Order::truncate();
        RechargeHistory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Tạo tài khoản Admin mẫu
        $admin = User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'email' => 'admin@webbanxu.com',
            'full_name' => 'Quản Trị Viên',
            'balance' => 0,
            'role' => 'admin',
            'status' => 1,
        ]);

        // 2. Tạo User người mua
        $user1 = User::create([
            'username' => 'nguyenvana',
            'password' => Hash::make('123456'),
            'email' => 'vana@gmail.com',
            'full_name' => 'Nguyễn Văn A',
            'balance' => 500000, // Tăng balance để đủ tiền test mua nhiều đơn
            'role' => 'user',
            'status' => 1,
        ]);

        // 3. Tạo danh mục (Categories)
        $tds = Category::create([
            'name' => 'Trao Đổi Sub',
            'description' => 'Tài khoản chứa xu Traodoisub.com'
        ]);

        $ttc = Category::create([
            'name' => 'Tương Tác Chéo',
            'description' => 'Tài khoản chứa xu Tuongtaccheo.com'
        ]);

        // 4. Tạo dữ liệu tài khoản mẫu
        // Tạo 10 acc ngẫu nhiên để có cái để mua
        for ($i = 1; $i <= 10; $i++) {
            Account::create([
                'category_id' => ($i <= 5) ? $tds->id : $ttc->id,
                'acc_username' => "nick_test_$i",
                'acc_password' => "pass_$i",
                'xu_amount' => rand(100000, 1000000),
                'price' => 10000, // Để giá cố định 10k cho dễ test
                'status' => 0, 
            ]);
        }

        // 5. QUAN TRỌNG: Tạo đơn hàng mẫu (Orders)
        // Lấy 3 tài khoản bất kỳ để tạo đơn hàng cho User1
        $accountsToBuy = Account::limit(3)->get();
        foreach ($accountsToBuy as $acc) {
            Order::create([
                'user_id' => $user1->id,
                'account_id' => $acc->id,
                'total_price' => $acc->price,
            ]);
            // Sau khi tạo đơn hàng, cập nhật status account thành đã bán (1)
            $acc->update(['status' => 1]);
        }

        // 6. Tạo lịch sử nạp tiền
        RechargeHistory::create([
            'user_id' => $user1->id,
            'amount' => 50000,
            'method' => 'MbBank',
            'status' => 1,
        ]);

        $this->command->info('Database đã được Seed thành công kèm theo đơn hàng mẫu!');
    }
}