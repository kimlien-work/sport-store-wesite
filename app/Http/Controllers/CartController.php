<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $this->cartService->add(
            $request->product_id,
            $request->variant_id,
            $request->quantity
        );

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function update($key, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->update($key, $request->quantity);
        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công.');
    }

    public function remove($key)
    {
        $this->cartService->remove($key);
        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function clear()
    {
        $this->cartService->clear();
        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng.');
    }

    // Lấy số lượng sản phẩm trong giỏ (cho AJAX)
    public function count()
    {
        return response()->json(['count' => $this->cartService->totalItems()]);
    }
}