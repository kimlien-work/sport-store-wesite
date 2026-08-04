@extends('layouts.app')

@section('content')
<h2>Thêm banner mới</h2>
<form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Tiêu đề</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Hình ảnh</label>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" required>
        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Link (URL)</label>
        <input type="url" name="link" class="form-control" value="{{ old('link') }}">
    </div>
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="active" value="1" checked>
            <label class="form-check-label">Hiển thị</label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection