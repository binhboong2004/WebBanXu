<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
{
    return [
        'category_id'  => $this->faker->randomElement([1, 2]), 
        'acc_username' => $this->faker->userName(),
        'acc_password' => bcrypt('password123'),
        'xu_amount'    => $this->faker->randomElement([500000, 1000000, 2000000, 5000000]),
        'price'        => $this->faker->randomElement([20000, 50000, 100000]),
        
        // Thay 'active' bằng số 1 (1- đang bán, 0- dừng bán)
        'status'       => 1, 
        
        'created_at'   => now(),
        'updated_at'   => now(),
    ];
}
}