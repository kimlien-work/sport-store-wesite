<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id')->toArray();

        $products = [
            [
                'name' => 'Giày chạy bộ Nike Air Max',
                'price' => 2500000,
                'sale_price' => 1990000,
                'stock' => 50,
                'description' => 'Giày chạy bộ cao cấp với đệm Air Max, thoải mái cho mọi hoạt động.',
            ],
            [
                'name' => 'Áo thun thể thao Adidas',
                'price' => 800000,
                'sale_price' => null,
                'stock' => 100,
                'description' => 'Áo thun cotton thoáng mát, thích hợp cho gym và chạy bộ.',
            ],
            [
                'name' => 'Bóng đá cao cấp',
                'price' => 1200000,
                'sale_price' => 999000,
                'stock' => 30,
                'description' => 'Bóng đá tiêu chuẩn FIFA, chất liệu da tổng hợp.',
            ],
        ];

        foreach ($products as $index => $p) {
            $categoryId = $categoryIds[$index % count($categoryIds)];
            $product = Product::create([
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'price' => $p['price'],
                'sale_price' => $p['sale_price'],
                'stock' => $p['stock'],
                'description' => $p['description'],
                'category_id' => $categoryId,
                'is_active' => true,
            ]);

            // Tạo ảnh mẫu (giả lập)
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/sample-' . ($index+1) . '.jpg',
                'is_main' => true,
            ]);

            // Tạo biến thể (size, color)
            ProductVariant::create([
                'product_id' => $product->id,
                'size' => 'M',
                'color' => 'Đỏ',
                'stock' => 20,
                'price' => null,
            ]);
            ProductVariant::create([
                'product_id' => $product->id,
                'size' => 'L',
                'color' => 'Xanh',
                'stock' => 15,
                'price' => null,
            ]);
        }
    }
}
