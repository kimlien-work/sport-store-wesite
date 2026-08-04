@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Mã giảm giá</h2>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Thêm mã</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Mã</th>
            <th>Loại</th>
            <th>Giá trị</th>
            <th>Hạn sử dụng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse($coupons as $coupon)
            <tr>
                <td>{{ $coupon->id }}</td>
                <td><strong>{{ $coupon->code }}</strong></td>
                <td>{{ $coupon->discount_type == 'percent' ? 'Phần trăm' : 'Cố định' }}</td>
                <td>{{ $coupon->discount_type == 'percent' ? $coupon->value . '%' : number_format($coupon->value) . 'đ' }}</td>
                <td>{{ $coupon->expiry ? $coupon->expiry->format('d/m/Y') : 'Vô hạn' }}</td>
                <td>
                    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Xóa mã?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">Chưa có mã giảm giá.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $coupons->links() }}
@endsection