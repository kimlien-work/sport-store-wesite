<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with('category', 'images', 'variants', 'reviews.user')
            ->firstOrFail();

        // Kiểm tra xem user đã mua sản phẩm chưa để cho phép đánh giá
        $canReview = false;
        if (auth()->check()) {
            $user = auth()->user();
            $canReview = $user->orders()
                ->where('status', 'delivered')
                ->whereHas('items', function ($q) use ($product) {
                    $q->where('product_id', $product->id);
                })
                ->exists();
        }

        return view('products.show', compact('product', 'canReview'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->paginate(12);

        return view('products.search', compact('products', 'query'));
    }

    // Autocomplete cho tìm kiếm nhanh (trả về JSON)
    public function autocomplete(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('is_active', true)
            ->where('name', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name', 'slug', 'price', 'sale_price']);

        return response()->json($products);
    }
}