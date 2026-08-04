<!DOCTYPE html>
<html>
<head><title>Xác nhận đơn hàng</title></head>
<body>
    <h3>Xin chào {{ $order->user->name }},</h3>
    <p>Cảm ơn bạn đã đặt hàng tại Sport Store!</p>
    <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($order->total) }}đ</p>
    <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
    <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method == 'cod' ? 'COD' : 'Chuyển khoản' }}</p>
    <p><strong>Trạng thái:</strong> 
        @switch($order->status)
            @case('pending') Chờ xác nhận @break
            @case('confirmed') Đã xác nhận @break
            @case('shipping') Đang giao @break
            @case('delivered') Đã giao @break
            @case('cancelled') Đã hủy @break
        @endswitch
    </p>
    <p>Xem chi tiết: <a href="{{ route('orders.show', $order) }}">Tại đây</a></p>
</body>
</html>