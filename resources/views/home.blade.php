@extends('layouts.frontend')

@section('title', 'Sport Store - Trang chủ')

@section('content')
<div class="container">
    <!-- Banner Slider -->
    @if(isset($banners) && $banners->count())
        <div id="bannerCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($banners as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <a href="{{ $banner->link ?? '#' }}">
                            <img src="{{ asset('storage/' . $banner->image) }}" class="d-block w-100 banner-img" alt="{{ $banner->title }}">
                        </a>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    @endif

    <!-- Danh mục nổi bật -->
    <section class="mb-5">
        <h2 class="text-center mb-4">Danh mục sản phẩm</h2>
        <div class="row">
            @foreach($categories ?? [] as $cat)
                <div class="col-6 col-md-3 col-lg-2 text-center mb-3">
                    <a href="{{ route('category.show', $cat->slug) }}" class="text-decoration-none">
                        @if($cat->image)
                            <img src="{{ asset('storage/' . $cat->image) }}" class="rounded-circle img-fluid" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width:80px;height:80px;color:#fff;">
                                <i class="bi bi-tag fs-2"></i>
                            </div>
                        @endif
                        <p class="mt-2">{{ $cat->name }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Sản phẩm mới -->
    <section class="mb-5">
        <h2 class="text-center mb-4">Sản phẩm mới</h2>
        <div class="row">
            @forelse($newProducts ?? [] as $product)
                <div class="col-6 col-md-3 mb-4">
                    <x-product-card :product="$product" />
                </div>
            @empty
                <p class="text-center">Chưa có sản phẩm mới.</p>
            @endforelse
        </div>
    </section>

    <!-- Sản phẩm bán chạy -->
    <section class="mb-5">
        <h2 class="text-center mb-4">Sản phẩm bán chạy</h2>
        <div class="row">
            @forelse($featuredProducts ?? [] as $product)
                <div class="col-6 col-md-3 mb-4">
                    <x-product-card :product="$product" />
                </div>
            @empty
                <p class="text-center">Chưa có sản phẩm nổi bật.</p>
            @endforelse
        </div>
    </section>

    <!-- Sản phẩm khuyến mãi -->
    <section class="mb-5">
        <h2 class="text-center mb-4">Khuyến mãi hot</h2>
        <div class="row">
            @forelse($saleProducts ?? [] as $product)
                <div class="col-6 col-md-3 mb-4">
                    <x-product-card :product="$product" />
                </div>
            @empty
                <p class="text-center">Hiện chưa có sản phẩm khuyến mãi.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection