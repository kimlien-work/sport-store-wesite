@extends('layouts.app')

@section('content')
<h2>Thêm mã giảm giá</h2>
<form action="{{ route('admin.coupons.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Mã code</label>
        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" required>
        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Loại giảm giá</label>
        <select name="discount_type" class="form-control">
            <option value="percent">Phần trăm (%)</option>
            <option value="fixed">Cố định (VNĐ)</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Giá trị</label>
        <input type="number" step="0.01" name="value" class="form-control" value="{{ old('value') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Ngày hết hạn (để trống nếu vô hạn)</label>
        <input type="datetime-local" name="expiry" class="form-control" value="{{ old('expiry') }}">
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection