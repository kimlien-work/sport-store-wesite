<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Coupon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@sportstore.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '0123456789',
            'address' => '123 Admin Street',
            'status' => true,
        ]);

        // Tạo khách hàng mẫu
        User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '0987654321',
            'address' => '456 User Street',
            'status' => true,
        ]);

        // Tạo danh mục
        $categories = [
            ['name' => 'Giày thể thao', 'slug' => 'giay-the-thao', 'description' => 'Giày thể thao chính hãng'],
            ['name' => 'Quần áo', 'slug' => 'quan-ao', 'description' => 'Quần áo thể thao thoải mái'],
            ['name' => 'Phụ kiện', 'slug' => 'phu-kien', 'description' => 'Phụ kiện thể thao đa dạng'],
            ['name' => 'Dụng cụ tập luyện', 'slug' => 'dung-cu-tap-luyen', 'description' => 'Dụng cụ hỗ trợ tập luyện'],
        ];
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Tạo sản phẩm mẫu (gọi ProductSeeder nếu có)
        $this->call(ProductSeeder::class);

        // Tạo banner
        Banner::create([
            'title' => 'Sale mùa hè',
            'image' => 'banners/summer-sale.jpg',
            'link' => '#',
            'active' => true,
        ]);

        // Tạo coupon
        Coupon::create([
            'code' => 'SUMMER20',
            'discount_type' => 'percent',
            'value' => 20,
            'expiry' => now()->addDays(30),
        ]);
    }
}