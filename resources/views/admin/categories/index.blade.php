@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Quản lý danh mục</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Thêm danh mục</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Ảnh</th>
            <th>Tên</th>
            <th>Slug</th>
            <th>Danh mục cha</th>
            <th>Số SP</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $cat)
            <tr>
                <td>{{ $cat->id }}</td>
                <td>
                    @if($cat->image)
                        <img src="{{ asset('storage/' . $cat->image) }}" width="50" height="50" style="object-fit:cover;">
                    @else
                        <span class="text-muted">Không</span>
                    @endif
                </td>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->slug }}</td>
                <td>{{ $cat->parent ? $cat->parent->name : '---' }}</td>
                <td>{{ $cat->products_count ?? 0 }}</td>
                <td>
                    <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Xóa danh mục này?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">Chưa có danh mục nào.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $categories->links() }}
@endsection