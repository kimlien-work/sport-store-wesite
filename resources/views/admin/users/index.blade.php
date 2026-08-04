@extends('layouts.app')

@section('content')
<div class="table-container">
    <div class="table-header">
        <h5><i class="fas fa-users me-2"></i>Quản lý người dùng</h5>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '---' }}</td>
                        <td>
                            <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-info' }}">
                                {{ $user->role == 'admin' ? 'Admin' : 'Khách hàng' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $user->status ? 'bg-success' : 'bg-secondary' }}">
                                {{ $user->status ? 'Hoạt động' : 'Bị khóa' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $user->status ? 'btn-danger' : 'btn-success' }}" 
                                        onclick="return confirm('Bạn có chắc muốn {{ $user->status ? 'khóa' : 'kích hoạt' }} tài khoản này?')">
                                    <i class="fas {{ $user->status ? 'fa-lock' : 'fa-unlock' }}"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">Không có người dùng nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
</div>
@endsection