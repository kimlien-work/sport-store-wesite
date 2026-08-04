@props(['product'])

<div class="card product-card h-100">
    <!-- Nút Yêu thích (Wishlist) -->
    <div class="position-absolute top-0 end-0 p-2 z-1">
        <button class="btn btn-light btn-sm rounded-circle shadow-sm text-muted">
            <i class="bi bi-heart"></i>
        </button>
    </div>
    
    <!-- Badge Giảm giá -->
    @if($product->sale_price)
        <div class="position-absolute top-0 start-0 p-2 z-1">
            <span class="badge bg-danger px-2 py-1">
                -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
            </span>
        </div>
    @endif

    <!-- Ảnh sản phẩm -->
    <a href="{{ route('products.show', $product->slug) }}">
        <img src="{{ $product->mainImage?->image_path ? asset('storage/' . $product->mainImage->image_path) : asset('images/no-image.png') }}" class="card-img-top" alt="{{ $product->name }}">
    </a>

    <!-- Thông tin -->
    <div class="card-body d-flex flex-column">
        <a href="{{ route('category.show', $product->category->slug ?? '') }}" class="text-muted text-decoration-none small mb-1">
            {{ $product->category->name ?? 'Không phân loại' }}
        </a>
        
        <h5 class="card-title fs-6 fw-bold mb-2">
            <a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none stretched-link">
                {{ Str::limit($product->name, 45) }}
            </a>
        </h5>

        <!-- Giá tiền -->
        <div class="mt-auto">
            @if($product->sale_price)
                <span class="text-danger fw-bold fs-5">{{ number_format($product->sale_price) }}đ</span>
                <span class="text-muted text-decoration-line-through small ms-1">{{ number_format($product->price) }}đ</span>
            @else
                <span class="text-dark fw-bold fs-5">{{ number_format($product->price) }}đ</span>
            @endif
        </div>
    </div>
</div>