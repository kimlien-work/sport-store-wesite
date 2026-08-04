@extends('layouts.app')

@section('content')
<h2>Chỉnh sửa banner</h2>
<form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Tiêu đề</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Hình ảnh hiện tại</label>
        <div><img src="{{ asset('storage/' . $banner->image) }}" width="200"></div>
        <input type="file" name="image" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Link</label>
        <input type="url" name="link" class="form-control" value="{{ old('link', $banner->link) }}">
    </div>
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="active" value="1" {{ $banner->active ? 'checked' : '' }}>
            <label class="form-check-label">Hiển thị</label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection