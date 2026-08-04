<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add($productId, $variantId = null, $qty = 1)
    {
        if (Auth::check()) {
            $this->addToDatabase($productId, $variantId, $qty);
        } else {
            $this->addToSession($productId, $variantId, $qty);
        }
    }

    /**
     * Xử lý lưu giỏ hàng vào Database (Cho User đã đăng nhập)
     */
    protected function addToDatabase($productId, $variantId, $qty)
    {
        $user = Auth::user();
        
        // Tìm giỏ hàng của user, nếu chưa có thì tạo mới
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Kiểm tra xem sản phẩm (và biến thể) này đã có trong giỏ hàng chưa
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();

        if ($cartItem) {
            // Nếu có rồi thì cộng dồn số lượng
            $cartItem->increment('quantity', $qty);
        } else {
            // Nếu chưa có thì tạo mới item
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity'   => $qty,
            ]);
        }
    }

    /**
     * Xử lý lưu giỏ hàng vào Session (Cho Guest - Khách vãng lai)
     */
    protected function addToSession($productId, $variantId, $qty)
    {
        $cart = Session::get('cart', []);

        // Tạo 1 key duy nhất cho mỗi loại sản phẩm + biến thể
        $key = $productId . '_' . ($variantId ?? '0');

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $qty;
        } else {
            $cart[$key] = [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity'   => $qty,
            ];
        }

        Session::put('cart', $cart);
    }

    /**
     * Đồng bộ giỏ hàng từ Session sang Database khi Guest đăng nhập
     */
    public function syncOnLogin()
    {
        $sessionCart = Session::get('cart', []);

        // Nếu giỏ hàng session trống thì không cần làm gì cả
        if (empty($sessionCart)) {
            return;
        }

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        foreach ($sessionCart as $item) {
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $item['product_id'])
                ->where('variant_id', $item['variant_id'])
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $item['quantity']);
            } else {
                CartItem::create([
                    'cart_id'    => $cart->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity'   => $item['quantity'],
                ]);
            }
        }

        // Xóa giỏ hàng trong session sau khi đã đồng bộ xong
        Session::forget('cart');
    }
    // Trong CartService
public function update($key, $quantity)
{
    if (auth()->check()) {
        // Xử lý database
        $cart = $this->getCart();
        $item = $cart->items()->find($key);
        if ($item) {
            $item->quantity = $quantity;
            $item->save();
        }
    } else {
        $cart = session()->get('cart', []);
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }
    }
}

public function remove($key)
{
    if (auth()->check()) {
        $cart = $this->getCart();
        $cart->items()->find($key)->delete();
    } else {
        $cart = session()->get('cart', []);
        unset($cart[$key]);
        session()->put('cart', $cart);
    }
}

public function clear()
{
    if (auth()->check()) {
        $cart = $this->getCart();
        $cart->items()->delete();
    } else {
        session()->forget('cart');
    }
}

public function totalItems()
{
    if (auth()->check()) {
        $cart = $this->getCart();
        return $cart->items->sum('quantity');
    } else {
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }
}
}