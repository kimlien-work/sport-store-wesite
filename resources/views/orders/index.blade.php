@extends('layouts.frontend')

@section('title', 'Lịch sử đơn hàng')

@section('content')
<div class="container">
    <h2>Lịch sử đơn hàng</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->count())
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ number_format($order->total) }}đ</td>
                            <td>
                                @switch($order->status)
                                    @case('pending')   <span class="badge bg-warning">Chờ xác nhận</span> @break
                                    @case('confirmed') <span class="badge bg-info">Đã xác nhận</span> @break
                                    @case('shipping')  <span class="badge bg-primary">Đang giao</span> @break
                                    @case('delivered') <span class="badge bg-success">Đã giao</span> @break
                                    @case('cancelled') <span class="badge bg-danger">Đã hủy</span> @break
                                    @default <span class="badge bg-secondary">{{ $order->status }}</span>
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Xem</a>
                                @if(in_array($order->status, ['pending', 'confirmed']))
                                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-danger">Hủy</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    @else
        <p class="text-center">Bạn chưa có đơn hàng nào.</p>
    @endif
</div>
@endsection