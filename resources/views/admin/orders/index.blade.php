@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Quản lý đơn hàng</h2>
    <div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Tất cả</a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-warning">Chờ xác nhận</a>
        <a href="{{ route('admin.orders.index', ['status' => 'shipping']) }}" class="btn btn-info">Đang giao</a>
        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="btn btn-success">Đã giao</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày đặt</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
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
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Không có đơn hàng nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $orders->links() }}
@endsection