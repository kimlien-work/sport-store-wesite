@extends('layouts.frontend')

@section('title', 'Chỉnh sửa hồ sơ')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Chỉnh sửa hồ sơ</h4>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium text-muted">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg bg-light" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-medium text-muted">Địa chỉ Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg bg-light" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium text-muted">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control form-control-lg bg-light" value="{{ old('phone', $user->phone) }}" placeholder="Ví dụ: 0987654321">
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-medium text-muted">Địa chỉ giao hàng</label>
                            <textarea name="address" class="form-control bg-light" rows="3" placeholder="Nhập địa chỉ nhà, tên đường, phường/xã, quận/huyện...">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5"><i class="bi bi-save me-2"></i>Lưu thay đổi</button>
                            <a href="{{ route('profile.index') }}" class="btn btn-light btn-lg rounded-pill px-4 text-muted">Hủy bỏ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection