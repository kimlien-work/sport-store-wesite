@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="fas fa-dollar-sign"></i></div>
            <div class="stat-number">{{ number_format($totalRevenue ?? 0) }}đ</div>
            <div class="stat-label">Tổng doanh thu</div>
            <div class="stat-change up"><i class="fas fa-arrow-up"></i> 12.5%</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="fas fa-shopping-cart"></i></div>
            <div class="stat-number">{{ $newOrders ?? 0 }}</div>
            <div class="stat-label">Đơn hàng mới</div>
            <div class="stat-change up"><i class="fas fa-arrow-up"></i> 8.2%</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-icon success"><i class="fas fa-users"></i></div>
            <div class="stat-number">{{ $totalUsers ?? 0 }}</div>
            <div class="stat-label">Khách hàng</div>
            <div class="stat-change up"><i class="fas fa-arrow-up"></i> 5.1%</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-icon info"><i class="fas fa-box"></i></div>
            <div class="stat-number">{{ $totalProducts ?? 0 }}</div>
            <div class="stat-label">Sản phẩm</div>
            <div class="stat-change down"><i class="fas fa-arrow-down"></i> 0.8%</div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row">
    <div class="col-12">
        <div class="table-container">
            <div class="table-header">
                <h5><i class="fas fa-clock me-2"></i>Đơn hàng gần đây</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">Xem tất cả</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>{{ number_format($order->total) }}đ</td>
                                <td>
                                    <span class="badge-status {{ $order->status }}">
                                        @switch($order->status)
                                            @case('pending') Chờ xác nhận @break
                                            @case('confirmed') Đã xác nhận @break
                                            @case('shipping') Đang giao @break
                                            @case('delivered') Đã giao @break
                                            @case('cancelled') Đã hủy @break
                                        @endswitch
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">Chưa có đơn hàng nào.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-md-3 col-6 mb-3">
        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary w-100 py-3">
            <i class="fas fa-plus-circle me-2"></i> Thêm sản phẩm
        </a>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-success w-100 py-3">
            <i class="fas fa-plus-circle me-2"></i> Thêm danh mục
        </a>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-outline-warning w-100 py-3">
            <i class="fas fa-plus-circle me-2"></i> Thêm mã giảm giá
        </a>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <a href="{{ route('admin.banners.create') }}" class="btn btn-outline-info w-100 py-3">
            <i class="fas fa-plus-circle me-2"></i> Thêm banner
        </a>
    </div>
</div>
@endsection