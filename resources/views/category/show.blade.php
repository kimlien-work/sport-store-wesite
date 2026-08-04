@extends('layouts.frontend')

@section('title', $category->name . ' - Sport Store')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar lọc -->
        <aside class="col-md-3 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">Bộ lọc</div>
                <div class="card-body">
                    <form action="{{ route('category.show', $category->slug) }}" method="GET">
                        <!-- Khoảng giá -->
                        <div class="mb-3">
                            <label class="fw-bold">Giá</label>
                            <div class="d-flex gap-2">
                                <input type="number" name="min_price" class="form-control" placeholder="Từ" value="{{ request('min_price') }}">
                                <input type="number" name="max_price" class="form-control" placeholder="Đến" value="{{ request('max_price') }}">
                            </div>
                        </div>

                        <!-- Kích cỡ (nếu có biến thể) -->
                        @php
                            $sizes = \App\Models\ProductVariant::whereIn('product_id', $category->products->pluck('id'))->distinct('size')->pluck('size')->filter();
                        @endphp
                        @if($sizes->count())
                            <div class="mb-3">
                                <label class="fw-bold">Kích cỡ</label>
                                <div>
                                    @foreach($sizes as $size)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="sizes[]" value="{{ $size }}" id="size{{ $size }}"
                                                {{ in_array($size, request('sizes', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="size{{ $size }}">{{ $size }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Màu sắc (tương tự) -->
                        <!-- Thương hiệu (nếu có) -->
                        <button type="submit" class="btn btn-primary w-100">Áp dụng</button>
                        <a href="{{ route('category.show', $category->slug) }}" class="btn btn-secondary w-100 mt-2">Xóa lọc</a>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Danh sách sản phẩm -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>{{ $category->name }}</h2>
                <!-- Sắp xếp -->
                <div>
                    <span>Sắp xếp: </span>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" class="btn btn-sm btn-outline-secondary">Giá tăng</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" class="btn btn-sm btn-outline-secondary">Giá giảm</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" class="btn btn-sm btn-outline-secondary">Mới nhất</a>
                </div>
            </div>

            <div class="row">
                @forelse($products as $product)
                    <div class="col-6 col-lg-4 mb-4">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="col-12"><p class="text-center">Không có sản phẩm nào trong danh mục này.</p></div>
                @endforelse
            </div>

            <!-- Phân trang -->
            <div class="d-flex justify-content-center">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
// Sử dụng Bootstrap Typeahead hoặc tự viết
$('#search-input').on('keyup', function() {
    let query = $(this).val();
    if (query.length >= 2) {
        $.get('/autocomplete', {q: query}, function(data) {
            // Hiển thị gợi ý
        });
    }
});