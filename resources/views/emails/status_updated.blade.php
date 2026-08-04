<!DOCTYPE html>
<html>
<head><title>Cập nhật đơn hàng</title></head>
<body>
    <h3>Xin chào {{ $order->user->name }},</h3>
    <p>Đơn hàng #{{ $order->id }} của bạn đã được cập nhật trạng thái:</p>
    <p><strong>Trạng thái mới:</strong> 
        @switch($order->status)
            @case('pending') Chờ xác nhận @break
            @case('confirmed') Đã xác nhận @break
            @case('shipping') Đang giao hàng @break
            @case('delivered') Đã giao hàng @break
            @case('cancelled') Đã hủy @break
        @endswitch
    </p>
    <p>Xem chi tiết: <a href="{{ route('orders.show', $order) }}">Tại đây</a></p>
    <p>Cảm ơn bạn đã mua hàng tại Sport Store!</p>
</body>
</html>