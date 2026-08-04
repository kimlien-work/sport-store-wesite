@extends('layouts.frontend')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                    <h3 class="fw-bold">Xin chào, {{ Auth::user()->name }}!</h3>
                    <p class="text-muted">Chào mừng bạn quay lại. Từ bảng điều khiển này, bạn có thể quản lý tài khoản và theo dõi đơn hàng dễ dàng.</p>
                </div>
                <div class="card-body px-4 pb-5">
                    <div class="row mt-4 g-4">
                        <!-- Card Quản lý Hồ sơ -->
                        <div class="col-md-4">
                            <div class="card bg-light border-0 h-100 text-center product-card">
                                <div class="card-body py-4">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                        <i class="bi bi-person-bounding-box fs-2 text-primary"></i>
                                    </div>
                                    <h5 class="fw-bold">Hồ sơ cá nhân</h5>
                                    <p class="text-muted small">Cập nhật thông tin liên hệ và địa chỉ giao hàng.</p>
                                    <a href="{{ route('profile.index') }}" class="btn btn-outline-primary btn-sm mt-2 rounded-pill px-4">Quản lý ngay</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card Đơn hàng -->
                        <div class="col-md-4">
                            <div class="card bg-light border-0 h-100 text-center product-card">
                                <div class="card-body py-4">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                        <i class="bi bi-box-seam fs-2 text-success"></i>
                                    </div>
                                    <h5 class="fw-bold">Lịch sử đơn hàng</h5>
                                    <p class="text-muted small">Kiểm tra trạng thái các đơn hàng đã đặt.</p>
                                    <a href="{{ route('orders.index') }}" class="btn btn-outline-success btn-sm mt-2 rounded-pill px-4">Xem lịch sử</a>
                                </div>
                            </div>
                        </div>

                        <!-- Card Giỏ hàng -->
                        <div class="col-md-4">
                            <div class="card bg-light border-0 h-100 text-center product-card">
                                <div class="card-body py-4">
                                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                        <i class="bi bi-cart-check fs-2 text-danger"></i>
                                    </div>
                                    <h5 class="fw-bold">Giỏ hàng</h5>
                                    <p class="text-muted small">Xem lại các sản phẩm bạn đã thêm vào giỏ.</p>
                                    <a href="{{ route('cart.index') }}" class="btn btn-outline-danger btn-sm mt-2 rounded-pill px-4">Đến giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection