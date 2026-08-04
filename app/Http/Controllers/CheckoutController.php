<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Events\OrderPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart; // Giả sử đã có quan hệ

        // Tính tổng tiền
        $total = 0;
        $items = [];
        if ($cart) {
            foreach ($cart->items as $item) {
                $price = $item->product->sale_price ?? $item->product->price;
                $subtotal = $price * $item->quantity;
                $total += $subtotal;
                $items[] = $item;
            }
        }

        return view('checkout', compact('items', 'total', 'user'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,bank',
            'coupon_code' => 'nullable|string|exists:coupons,code',
        ]);

        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        try {
            DB::beginTransaction();

            // Tính tổng tiền
            $total = 0;
            foreach ($cart->items as $item) {
                $price = $item->product->sale_price ?? $item->product->price;
                $total += $price * $item->quantity;
            }

            // Áp dụng coupon
            $discount = 0;
            if ($request->filled('coupon_code')) {
                $coupon = Coupon::where('code', $request->coupon_code)->first();
                if ($coupon && ($coupon->expiry === null || $coupon->expiry > now())) {
                    if ($coupon->discount_type === 'percent') {
                        $discount = $total * ($coupon->value / 100);
                    } else {
                        $discount = min($coupon->value, $total);
                    }
                }
            }

            $finalTotal = $total - $discount;

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $finalTotal,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
                'coupon_code' => $request->coupon_code,
                'discount' => $discount,
            ]);

            // Lưu order items và trừ stock
            foreach ($cart->items as $item) {
                $price = $item->product->sale_price ?? $item->product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                ]);

                // Trừ stock
                $product = Product::find($item->product_id);
                if ($product->stock < $item->quantity) {
                    throw new \Exception('Sản phẩm ' . $product->name . ' không đủ số lượng!');
                }
                $product->decrement('stock', $item->quantity);

                if ($item->variant_id) {
                    $item->variant->decrement('stock', $item->quantity);
                }
            }

            // Xóa giỏ hàng
            $cart->items()->delete();

            DB::commit();

            // Gửi email xác nhận
            event(new OrderPlaced($order));

            return redirect()->route('home')->with('success', 'Đặt hàng thành công! Đơn hàng #' . $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}