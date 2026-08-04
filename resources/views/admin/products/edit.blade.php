@extends('layouts.app')

@section('content')
<h2>Chỉnh sửa sản phẩm: {{ $product->name }}</h2>
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $product->slug) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Giá (VNĐ)</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giá khuyến mãi</label>
                <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Tồn kho</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                    <label class="form-check-label">Hiển thị</label>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
    </div>

    <!-- Ảnh hiện tại -->
    <div class="mb-3">
        <label class="form-label">Ảnh hiện tại</label>
        <div class="row">
            @foreach($product->images as $img)
                <div class="col-2 mb-2">
                    <img src="{{ asset('storage/' . $img->image_path) }}" class="img-thumbnail" width="100">
                    <div class="form-check mt-1">
                        <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $img->id }}">
                        <label class="form-check-label">Xóa</label>
                    </div>
                </div>
            @endforeach
        </div>
        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
    </div>

    <!-- Biến thể hiện tại và thêm mới -->
    <div class="card mb-3">
        <div class="card-header">
            <h6>Biến thể</h6>
        </div>
        <div class="card-body">
            <div id="variantContainer">
                @foreach($product->variants as $index => $variant)
                    <div class="row variant-row mb-2">
                        <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                        <div class="col-3">
                            <input type="text" name="variants[{{ $index }}][size]" class="form-control" value="{{ $variant->size }}" placeholder="Size">
                        </div>
                        <div class="col-3">
                            <input type="text" name="variants[{{ $index }}][color]" class="form-control" value="{{ $variant->color }}" placeholder="Màu">
                        </div>
                        <div class="col-3">
                            <input type="number" name="variants[{{ $index }}][stock]" class="form-control" value="{{ $variant->stock }}" placeholder="Tồn kho">
                        </div>
                        <div class="col-2">
                            <input type="number" name="variants[{{ $index }}][price]" class="form-control" value="{{ $variant->price }}" placeholder="Giá">
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn btn-danger removeVariant"><i class="bi bi-dash"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary btn-sm" id="addVariant"><i class="bi bi-plus"></i> Thêm biến thể</button>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
</form>

@push('scripts')
<script>
    let variantIndex = {{ $product->variants->count() }};
    document.getElementById('addVariant').addEventListener('click', function() {
        const container = document.getElementById('variantContainer');
        const row = document.createElement('div');
        row.className = 'row variant-row mb-2';
        row.innerHTML = `
            <div class="col-3"><input type="text" name="variants[${variantIndex}][size]" class="form-control" placeholder="Size"></div>
            <div class="col-3"><input type="text" name="variants[${variantIndex}][color]" class="form-control" placeholder="Màu"></div>
            <div class="col-3"><input type="number" name="variants[${variantIndex}][stock]" class="form-control" placeholder="Tồn kho"></div>
            <div class="col-2"><input type="number" name="variants[${variantIndex}][price]" class="form-control" placeholder="Giá"></div>
            <div class="col-1"><button type="button" class="btn btn-danger removeVariant"><i class="bi bi-dash"></i></button></div>
        `;
        container.appendChild(row);
        variantIndex++;
        row.querySelector('.removeVariant').addEventListener('click', function() {
            row.remove();
        });
    });

    document.querySelectorAll('.removeVariant').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('.variant-row');
            if (document.querySelectorAll('.variant-row').length > 1) {
                row.remove();
            } else {
                alert('Phải có ít nhất một biến thể.');
            }
        });
    });
</script>
@endpush
@endsection