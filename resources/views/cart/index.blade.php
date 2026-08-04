@extends('layouts.frontend')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container">
    <h2>Giỏ hàng của bạn</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(isset($cart) && $cart->count())
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $key => $item)
                        @php
                            $product = \App\Models\Product::find($item['product_id']);
                            $price = $product->sale_price ?? $product->price;
                            $subtotal = $price * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>
                                <img src="{{ $product->mainImage?->image_path ? asset('storage/' . $product->mainImage->image_path) : asset('images/no-image.png') }}" width="60" alt="">
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                @if($item['variant_id'])
                                    <br><small class="text-muted">Biến thể: {{ \App\Models\ProductVariant::find($item['variant_id'])->size ?? '' }} {{ \App\Models\ProductVariant::find($item['variant_id'])->color ?? '' }}</small>
                                @endif
                            </td>
                            <td>{{ number_format($price) }}đ</td>
                            <td>
                                <form action="{{ route('cart.update', $key) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control" style="width:70px; display:inline-block;">
                                    <button type="submit" class="btn btn-sm btn-secondary">Cập nhật</button>
                                </form>
                            </td>
                            <td>{{ number_format($subtotal) }}đ</td>
                            <td>
                                <form action="{{ route('cart.remove', $key) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa sản phẩm này?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Tổng cộng</td>
                        <td colspan="2" class="fw-bold">{{ number_format($total) }}đ</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between">
            <a href="{{ route('home') }}" class="btn btn-secondary">Tiếp tục mua sắm</a>
            @auth
                <a href="{{ route('checkout.index') }}" class="btn btn-success">Tiến hành thanh toán</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-warning">Đăng nhập để thanh toán</a>
            @endauth
        </div>
    @else
        <p class="text-center">Giỏ hàng của bạn đang trống.</p>
        <div class="text-center"><a href="{{ route('home') }}" class="btn btn-primary">Mua sắm ngay</a></div>
    @endif
</div>
@endsection