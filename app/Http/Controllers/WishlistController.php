<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Auth::user()->wishlist()->with('product')->get();
        return view('wishlist.index', compact('wishlist'));
    }

    public function add($productId)
    {
        $product = Product::findOrFail($productId);
        Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ]);
        return redirect()->back()->with('success', 'Đã thêm vào danh sách yêu thích.');
    }

    public function remove($productId)
    {
        Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->delete();
        return redirect()->back()->with('success', 'Đã xóa khỏi danh sách yêu thích.');
    }
}