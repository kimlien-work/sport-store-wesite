@extends('layouts.app')

@section('content')
<div class="table-container">
   
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Quản lý sản phẩm</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm sản phẩm
    </a>
</div>
</div>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Giá KM</th>
                <th>Tồn kho</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        <img src="{{ $product->mainImage?->image_path ? asset('storage/' . $product->mainImage->image_path) : asset('images/no-image.png') }}" width="50" height="50" style="object-fit:cover;">
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>{{ number_format($product->price) }}đ</td>
                    <td>{{ $product->sale_price ? number_format($product->sale_price).'đ' : '---' }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $product->is_active ? 'Hiển thị' : 'Ẩn' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Xóa sản phẩm này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center">Chưa có sản phẩm.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $products->links() }}
@endsection