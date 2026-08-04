@extends('layouts.frontend')

@section('content')
<div class="container">
    <h2>Thanh toán</h2>
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label>Địa chỉ giao hàng</label>
            <input type="text" name="shipping_address" class="form-control" required value="{{ old('shipping_address', Auth::user()->address ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Phương thức thanh toán</label>
            <select name="payment_method" class="form-control">
                <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                <option value="bank">Chuyển khoản ngân hàng</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Mã giảm giá (nếu có)</label>
            <input type="text" name="coupon_code" class="form-control" placeholder="Nhập mã..." value="{{ old('coupon_code') }}">
        </div>

        <div class="mb-3">
            <strong>Tổng tiền:</strong> <span id="totalPrice">{{ number_format($total ?? 0) }}đ</span>
        </div>

        <button type="submit" class="btn btn-success">Hoàn tất đặt hàng</button>
    </form>
</div>
@endsection