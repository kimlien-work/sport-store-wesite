<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $query = Product::where('category_id', $category->id)->where('is_active', true);

        // Lọc theo khoảng giá
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Lọc theo kích cỡ (nếu có biến thể)
        if ($request->has('sizes') && !empty($request->sizes)) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereIn('size', $request->sizes);
            });
        }

        // Lọc theo màu (tương tự)
        if ($request->has('colors') && !empty($request->colors)) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereIn('color', $request->colors);
            });
        }

        // Sắp xếp
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);

        // Lấy danh sách size và color có sẵn để hiển thị filter
        $productIds = $query->pluck('id');
        $sizes = ProductVariant::whereIn('product_id', $productIds)
            ->whereNotNull('size')
            ->distinct('size')
            ->pluck('size')
            ->filter();
            
        $colors = ProductVariant::whereIn('product_id', $productIds)
            ->whereNotNull('color')
            ->distinct('color')
            ->pluck('color')
            ->filter();

        return view('category.show', compact('category', 'products', 'sizes', 'colors'));
    }
}