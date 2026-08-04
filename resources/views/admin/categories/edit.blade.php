@extends('layouts.app')

@section('content')
<h2>Chỉnh sửa danh mục: {{ $category->name }}</h2>
<form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Tên danh mục</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Danh mục cha</label>
        <select name="parent_id" class="form-control">
            <option value="">Không có</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}" {{ (old('parent_id', $category->parent_id) == $parent->id) ? 'selected' : '' }}>{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Hình ảnh hiện tại</label>
        @if($category->image)
            <div><img src="{{ asset('storage/' . $category->image) }}" width="100"></div>
        @endif
        <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection