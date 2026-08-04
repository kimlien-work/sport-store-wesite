@extends('layouts.frontend')

@section('title', 'Hồ sơ của tôi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-5 pb-0 text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4fc3f7&color=fff&size=100&bold=true" class="rounded-circle shadow-sm mb-3" alt="Avatar">
                    <h3 class="fw-bold mb-1">{{ Auth::user()->name }}</h3>
                    <p class="text-muted"><i class="bi bi-envelope-fill text-primary me-2"></i>{{ Auth::user()->email }}</p>
                </div>
                <div class="card-body px-5 py-4">
                    <h5 class="fw-bold border-bottom pb-3 mb-4"><i class="bi bi-info-circle text-primary me-2"></i>Thông tin liên hệ</h5>
                    
                    <div class="row mb-3 align-items-center">
                        <div class="col-sm-4 text-muted"><i class="bi bi-person me-2"></i>Họ và tên</div>
                        <div class="col-sm-8 fw-medium fs-6">{{ Auth::user()->name }}</div>
                    </div>
                    
                    <div class="row mb-3 align-items-center">
                        <div class="col-sm-4 text-muted"><i class="bi bi-telephone me-2"></i>Số điện thoại</div>
                        <div class="col-sm-8 fw-medium fs-6">{{ Auth::user()->phone ?? 'Chưa cập nhật' }}</div>
                    </div>
                    
                    <div class="row mb-4 align-items-center">
                        <div class="col-sm-4 text-muted"><i class="bi bi-geo-alt me-2"></i>Địa chỉ giao hàng</div>
                        <div class="col-sm-8 fw-medium fs-6">{{ Auth::user()->address ?? 'Chưa cập nhật' }}</div>
                    </div>
                    
                    <div class="d-flex gap-3 pt-3 border-top">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary rounded-pill px-4"><i class="bi bi-pencil-square me-2"></i>Cập nhật thông tin</a>
                        <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection