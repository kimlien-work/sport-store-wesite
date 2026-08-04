<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $order->load('items.product', 'items.variant');
        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'Không thể hủy đơn hàng này.');
        }

        $order->status = 'cancelled';
        $order->save();

        // Gửi email thông báo hủy (tùy chọn)
        // event(new OrderStatusChanged($order));

        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được hủy.');
    }
}