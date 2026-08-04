@extends('layouts.frontend')

@section('title', 'Danh sách yêu thích')

@section('content')
<div class="container">
    <h2>Danh sách yêu thích</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($wishlist->count())
        <div class="row">
            @foreach($wishlist as $item)
                <div class="col-6 col-md-3 mb-4">
                    <x-product-card :product="$item->product" />
                    <form action="{{ route('wishlist.remove', $item->product_id) }}" method="POST" class="mt-2">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100">Xóa khỏi yêu thích</button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <p>Bạn chưa có sản phẩm yêu thích nào.</p>
    @endif
</div>
@endsection