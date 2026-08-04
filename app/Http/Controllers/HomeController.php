<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Ví dụ: Lấy 8 sản phẩm mới nhất đang active
        $latestProducts = Product::where('is_active', true)
                                 ->orderBy('created_at', 'desc')
                                 ->take(8)
                                 ->get();

        // Lấy danh sách danh mục
        $categories = Category::all();

        // Trả về view 'home.blade.php' kèm theo dữ liệu
        return view('home', compact('latestProducts', 'categories'));
    }
}
