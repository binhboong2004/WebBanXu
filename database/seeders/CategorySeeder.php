<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Trao Đổi Sub', 'description' => 'Xu sạch không cấu hình người dùng'],
            ['name' => 'Tương Tác Chéo', 'description' => 'Xu sạch không cấu hình người dùng'],
        ];

        foreach($categories as $category){
            Category::create($category);
        }
    }
}
