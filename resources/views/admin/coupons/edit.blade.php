@extends('layouts.app')

@section('content')
<h2>Chỉnh sửa mã giảm giá: {{ $coupon->code }}</h2>
<form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Mã code</label>
        <input type="text" name="code" class="form-control" value="{{ old('code', $coupon->code) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Loại giảm giá</label>
        <select name="discount_type" class="form-control">
            <option value="percent" {{ $coupon->discount_type == 'percent' ? 'selected' : '' }}>Phần trăm</option>
            <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Cố định</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Giá trị</label>
        <input type="number" step="0.01" name="value" class="form-control" value="{{ old('value', $coupon->value) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Ngày hết hạn</label>
        <input type="datetime-local" name="expiry" class="form-control" value="{{ old('expiry', optional($coupon->expiry)->format('Y-m-d\TH:i')) }}">
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection