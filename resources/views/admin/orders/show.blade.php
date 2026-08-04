@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Khách hàng:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                <p><strong>SĐT:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
                <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Phương thức TT:</strong> {{ $order->payment_method == 'cod' ? 'COD' : 'Chuyển khoản' }}</p>
                <p><strong>Trạng thái hiện tại:</strong> 
                    @switch($order->status)
                        @case('pending')   <span class="badge bg-warning">Chờ xác nhận</span> @break
                        @case('confirmed') <span class="badge bg-info">Đã xác nhận</span> @break
                        @case('shipping')  <span class="badge bg-primary">Đang giao</span> @break
                        @case('delivered') <span class="badge bg-success">Đã giao</span> @break
                        @case('cancelled') <span class="badge bg-danger">Đã hủy</span> @break
                        @default <span class="badge bg-secondary">{{ $order->status }}</span>
                    @endswitch
                </p>
            </div>
        </div>
        <hr>

        <h6>Danh sách sản phẩm</h6>
        <table class="table table-bordered">
            <thead>
                <tr><th>Sản phẩm</th><th>Biến thể</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th></tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Đã xóa' }}</td>
                        <td>{{ $item->variant ? $item->variant->size . ' - ' . $item->variant->color : '---' }}</td>
                        <td>{{ number_format($item->price) }}đ</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price * $item->quantity) }}đ</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end fw-bold">Tổng cộng</td>
                    <td class="fw-bold">{{ number_format($order->total) }}đ</td>
                </tr>
            </tfoot>
        </table>

        <!-- Cập nhật trạng thái -->
        <div class="mt-3">
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="row g-3">
                @csrf
                @method('PATCH')
                <div class="col-auto">
                    <select name="status" class="form-select">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection