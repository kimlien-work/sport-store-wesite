<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class ProductsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Bỏ qua header (dòng đầu tiên)
        $rows->shift();
        
        foreach ($rows as $row) {
            // Kiểm tra dữ liệu hợp lệ
            if (empty($row[0]) || empty($row[1])) {
                continue; // Bỏ qua dòng trống
            }

            $categoryName = $row[2] ?? 'Chưa phân loại';
            $categorySlug = Str::slug($categoryName);
            
            // Tìm hoặc tạo category
            $category = Category::firstOrCreate(
                ['slug' => $categorySlug],
                ['name' => $categoryName]
            );
            
            // Xử lý giá
            $price = preg_replace('/[^0-9.]/', '', (string) $row[1]);
            $price = (float) $price;
            
            $productName = trim($row[0]);
            $productSlug = Str::slug($productName);
            
            // Kiểm tra sản phẩm đã tồn tại chưa
            $product = Product::where('slug', $productSlug)->first();
            
            if ($product) {
                // Cập nhật nếu đã tồn tại
                $product->update([
                    'price' => $price,
                    'description' => $row[3] ?? '',
                    'category_id' => $category->id,
                    'stock' => rand(10, 100),
                    'is_active' => true,
                ]);
            } else {
                // Tạo mới nếu chưa có
                Product::create([
                    'name' => $productName,
                    'slug' => $productSlug,
                    'price' => $price,
                    'sale_price' => null,
                    'stock' => rand(10, 100),
                    'description' => $row[3] ?? '',
                    'category_id' => $category->id,
                    'is_active' => true,
                ]);
            }
        }
    }
}
