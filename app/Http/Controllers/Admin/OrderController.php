<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Events\OrderStatusChanged;
use Illuminate\Http\Request;

class OrderController extends Controller
{public function newCount()
{
    $count = Order::where('status', 'pending')->count();
    return response()->json(['count' => $count]);
}
    public function index(Request $request)
    {
        $query = Order::with('user');
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        $orders = $query->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'items.variant', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,delivered,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        // Gửi email thông báo (nếu trạng thái thay đổi)
        if ($oldStatus != $request->status) {
            event(new OrderStatusChanged($order));
        }

        return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }
}