@extends('layouts.frontend')
@section('title', 'Tìm kiếm: ' . $query)
@section('content')
<div class="container">
    <h2>Kết quả tìm kiếm cho "{{ $query }}"</h2>
    @if($products->count())
        <div class="row">
            @foreach($products as $product)
                <div class="col-6 col-md-3 mb-4">
                    <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>
        {{ $products->appends(['q' => $query])->links() }}
    @else
        <p>Không tìm thấy sản phẩm nào.</p>
    @endif
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