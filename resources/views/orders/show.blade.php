@extends('layouts.frontend')

@section('title', 'Đơn hàng #' . $order->id)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Lịch sử đơn hàng</a></li>
            <li class="breadcrumb-item active">Đơn hàng #{{ $order->id }}</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h5>Thông tin đơn hàng</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Mã đơn:</strong> #{{ $order->id }}</p>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Trạng thái:</strong> 
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
                <div class="col-md-6">
                    <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method == 'cod' ? 'COD' : 'Chuyển khoản' }}</p>
                    <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Tổng tiền:</strong> <span class="fw-bold">{{ number_format($order->total) }}đ</span></p>
                </div>
            </div>

            <hr>
            <h6>Chi tiết sản phẩm</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    {{ $item->product->name ?? 'Sản phẩm đã xóa' }}
                                    @if($item->variant)
                                        <br><small>{{ $item->variant->size ?? '' }} {{ $item->variant->color ?? '' }}</small>
                                    @endif
                                </td>
                                <td>{{ number_format($item->price) }}đ</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price * $item->quantity) }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Tổng cộng</td>
                            <td class="fw-bold">{{ number_format($order->total) }}đ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại</a>
        @if(in_array($order->status, ['pending', 'confirmed']))
            <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
            </form>
        @endif
    </div>
</div>
@endsection