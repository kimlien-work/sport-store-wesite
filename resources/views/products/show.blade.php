@extends('layouts.frontend')

@section('title', $product->name)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.show', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Hình ảnh -->
        <div class="col-md-6">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($product->images as $key => $img)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $img->image_path) }}" class="d-block w-100" alt="{{ $product->name }}" style="max-height:400px; object-fit:contain;">
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
            <!-- Zoom có thể dùng thư viện, tạm thời bỏ qua -->
        </div>

        <!-- Thông tin -->
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <div class="mb-2">
                @if($product->sale_price)
                    <span class="h4 text-danger">{{ number_format($product->sale_price) }}đ</span>
                    <span class="text-muted text-decoration-line-through">{{ number_format($product->price) }}đ</span>
                @else
                    <span class="h4">{{ number_format($product->price) }}đ</span>
                @endif
            </div>
            <p class="text-muted">Tình trạng: {{ $product->stock > 0 ? 'Còn hàng' : 'Hết hàng' }}</p>
            <p class="mb-3">{{ $product->description }}</p>

            <!-- Biến thể (size, color) -->
            @if($product->variants->count())
                <form id="variantForm" class="mb-3">
                    <div class="row">
                        @php
                            $sizes = $product->variants->groupBy('size')->keys();
                            $colors = $product->variants->groupBy('color')->keys();
                        @endphp
                        @if($sizes->count())
                            <div class="col-md-6">
                                <label class="fw-bold">Kích cỡ</label>
                                <div>
                                    @foreach($sizes as $size)
                                        <button type="button" class="btn btn-outline-secondary btn-sm variant-btn" data-attribute="size" data-value="{{ $size }}">{{ $size }}</button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($colors->count())
                            <div class="col-md-6">
                                <label class="fw-bold">Màu sắc</label>
                                <div>
                                    @foreach($colors as $color)
                                        <button type="button" class="btn btn-outline-secondary btn-sm variant-btn" data-attribute="color" data-value="{{ $color }}">{{ $color }}</button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <input type="hidden" name="variant_id" id="selectedVariant" value="">
                </form>
            @endif

            <!-- Số lượng và thêm giỏ -->
            <form action="{{ route('cart.add') }}" method="POST" class="row g-3 align-items-end">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variant_id" id="variantHidden" value="">
                <div class="col-auto">
                    <label class="fw-bold">Số lượng</label>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width:80px;">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                    </button>
                </div>
            </form>

            <!-- Đánh giá -->
            <hr>
            <h5>Đánh giá ({{ $product->reviews->count() }})</h5>
            @forelse($product->reviews as $review)
                <div class="border-bottom py-2">
                    <strong>{{ $review->user->name }}</strong>
                    <span class="text-warning">
                        @for($i=1; $i<=5; $i++)
                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                        @endfor
                    </span>
                    <p>{{ $review->comment }}</p>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                </div>
            @empty
                <p>Chưa có đánh giá nào.</p>
            @endforelse

            @auth
                <!-- Form đánh giá (chỉ hiển thị nếu đã mua sản phẩm) -->
                @if(auth()->user()->orders->where('status', 'delivered')->flatMap->items->pluck('product_id')->contains($product->id))
                    <form action="{{ route('reviews.store') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-2">
                            <label>Đánh giá (1-5 sao)</label>
                            <select name="rating" class="form-control" style="width:100px;">
                                @for($i=1; $i<=5; $i++) <option value="{{ $i }}">{{ $i }} sao</option> @endfor
                            </select>
                        </div>
                        <div class="mb-2">
                            <textarea name="comment" class="form-control" placeholder="Nhận xét của bạn..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">Gửi đánh giá</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Chọn biến thể
    document.querySelectorAll('.variant-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const attr = this.dataset.attribute;
            const val = this.dataset.value;
            // Lấy các lựa chọn khác
            const form = document.getElementById('variantForm');
            const selected = {};
            form.querySelectorAll('.variant-btn.btn-primary').forEach(b => {
                selected[b.dataset.attribute] = b.dataset.value;
            });
            selected[attr] = val;
            // Cập nhật giao diện
            form.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('btn-primary', 'btn-outline-secondary'));
            form.querySelectorAll('.variant-btn').forEach(b => {
                if (b.dataset.attribute === attr && b.dataset.value === val) {
                    b.classList.add('btn-primary');
                } else {
                    b.classList.add('btn-outline-secondary');
                }
            });
            // Tìm variant_id tương ứng
            const variant = @json($product->variants);
            const found = variant.find(v => v.size === selected.size && v.color === selected.color);
            document.getElementById('selectedVariant').value = found ? found.id : '';
            document.getElementById('variantHidden').value = found ? found.id : '';
        });
    });
</script>
@endpush
@endsection