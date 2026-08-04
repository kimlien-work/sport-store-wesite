<!DOCTYPE html>
<html>
<head><title>Cập nhật đơn hàng</title></head>
<body>
    <h3>Xin chào {{ $order->user->name }},</h3>
    <p>Đơn hàng #{{ $order->id }} của bạn đã thay đổi trạng thái từ <strong>{{ $oldStatus }}</strong> sang <strong>{{ $order->status }}</strong>.</p>
    <p>Chi tiết đơn hàng: <a href="{{ route('orders.show', $order) }}">Xem chi tiết</a></p>
    <p>Cảm ơn bạn đã mua hàng tại Sport Store!</p>
</body>
</html>