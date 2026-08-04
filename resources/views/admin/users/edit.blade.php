@extends('layouts.app')

@section('content')
<div class="form-container">
    <h5 class="form-title"><i class="fas fa-user-edit me-2"></i>Chỉnh sửa người dùng</h5>
    
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Họ tên</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Vai trò</label>
                    <select name="role" class="form-select">
                        <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="status" value="1" {{ $user->status ? 'checked' : '' }}>
                <label class="form-check-label">Kích hoạt tài khoản</label>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Cập nhật
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
        </a>
    </form>
</div>
@endsection