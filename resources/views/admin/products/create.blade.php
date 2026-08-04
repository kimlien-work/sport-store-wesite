@extends('layouts.app')

@section('content')
<h2>Thêm sản phẩm mới</h2>
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                    <option value="">-- Chọn --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Giá (VNĐ)</label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Giá khuyến mãi (VNĐ)</label>
                <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Tồn kho</label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}" required>
                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label">Hiển thị</label>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Hình ảnh (chọn nhiều)</label>
        <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror" multiple accept="image/*">
        @error('images') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Biến thể (size/color) -->
    <div class="card mb-3">
        <div class="card-header">
            <h6>Biến thể (Size, Màu sắc)</h6>
        </div>
        <div class="card-body">
            <div id="variantContainer">
                <div class="row variant-row mb-2">
                    <div class="col-3">
                        <input type="text" name="variants[0][size]" class="form-control" placeholder="Size (vd: M)">
                    </div>
                    <div class="col-3">
                        <input type="text" name="variants[0][color]" class="form-control" placeholder="Màu (vd: Đỏ)">
                    </div>
                    <div class="col-3">
                        <input type="number" name="variants[0][stock]" class="form-control" placeholder="Tồn kho">
                    </div>
                    <div class="col-2">
                        <input type="number" name="variants[0][price]" class="form-control" placeholder="Giá (nếu khác)">
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-danger removeVariant"><i class="bi bi-dash"></i></button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary btn-sm" id="addVariant"><i class="bi bi-plus"></i> Thêm biến thể</button>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
</form>

@push('scripts')
<script>
    let variantIndex = 1;
    document.getElementById('addVariant').addEventListener('click', function() {
        const container = document.getElementById('variantContainer');
        const row = document.createElement('div');
        row.className = 'row variant-row mb-2';
        row.innerHTML = `
            <div class="col-3"><input type="text" name="variants[${variantIndex}][size]" class="form-control" placeholder="Size"></div>
            <div class="col-3"><input type="text" name="variants[${variantIndex}][color]" class="form-control" placeholder="Màu"></div>
            <div class="col-3"><input type="number" name="variants[${variantIndex}][stock]" class="form-control" placeholder="Tồn kho"></div>
            <div class="col-2"><input type="number" name="variants[${variantIndex}][price]" class="form-control" placeholder="Giá (nếu khác)"></div>
            <div class="col-1"><button type="button" class="btn btn-danger removeVariant"><i class="bi bi-dash"></i></button></div>
        `;
        container.appendChild(row);
        variantIndex++;
        // Gắn sự kiện xóa
        row.querySelector('.removeVariant').addEventListener('click', function() {
            row.remove();
        });
    });

    // Gắn sự kiện xóa cho các nút có sẵn
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