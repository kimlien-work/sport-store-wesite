@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Quản lý Banner</h2>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Thêm banner</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Hình ảnh</th>
            <th>Tiêu đề</th>
            <th>Link</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse($banners as $banner)
            <tr>
                <td>{{ $banner->id }}</td>
                <td><img src="{{ asset('storage/' . $banner->image) }}" width="100" style="object-fit:cover;"></td>
                <td>{{ $banner->title }}</td>
                <td>{{ $banner->link ?? '---' }}</td>
                <td><span class="badge {{ $banner->active ? 'bg-success' : 'bg-secondary' }}">{{ $banner->active ? 'Hiển thị' : 'Ẩn' }}</span></td>
                <td>
                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Xóa banner?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">Chưa có banner.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $banners->links() }}
@endsection