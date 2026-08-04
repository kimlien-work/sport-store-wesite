@extends('layouts.app')

@section('content')
<div class="table-container">
    <div class="table-header">
        <h5><i class="fas fa-star me-2"></i>Quản lý đánh giá</h5>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sản phẩm</th>
                    <th>Người dùng</th>
                    <th>Đánh giá</th>
                    <th>Nội dung</th>
                    <th>Ngày</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>{{ $review->product->name ?? 'N/A' }}</td>
                        <td>{{ $review->user->name ?? 'N/A' }}</td>
                        <td>
                            @for($i=1; $i<=5; $i++)
                                <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}" 
                                   style="color: {{ $i <= $review->rating ? '#f39c12' : '#ddd' }}"></i>
                            @endfor
                        </td>
                        <td>{{ Str::limit($review->comment, 50) }}</td>
                        <td>{{ $review->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa đánh giá này?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">Chưa có đánh giá nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $reviews->links() }}
</div>
@endsection