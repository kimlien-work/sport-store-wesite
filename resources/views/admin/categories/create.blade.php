@extends('layouts.app')

@section('content')
<h2>Thêm danh mục mới</h2>
<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Tên danh mục</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Slug (để trống tự tạo)</label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Danh mục cha</label>
        <select name="parent_id" class="form-control">
            <option value="">Không có</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Hình ảnh</label>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection