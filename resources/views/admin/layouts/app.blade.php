<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; overflow-x: hidden; }
        .sidebar { min-height: 100vh; background-color: #212529; }
        .sidebar a { color: #fff; text-decoration: none; padding: 10px 15px; display: block; }
        .sidebar a:hover, .sidebar a.active { background-color: #0d6efd; }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar flex-shrink-0 p-3" style="width: 250px;">
        <h4 class="text-white border-bottom pb-3">Admin Panel</h4>
        <ul class="nav nav-pills flex-column mb-auto mt-3">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam me-2"></i> Sản phẩm
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="bi bi-cart me-2"></i> Đơn hàng
                </a>
            </li>
        </ul>
        <hr class="text-white">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Đăng xuất</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 bg-light">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4">
            <span class="navbar-brand mb-0 h1">Xin chào, {{ Auth::user()->name }}</span>
        </nav>

        <!-- Content Area -->
        <div class="p-4">
            <!-- Hiển thị thông báo (Flash messages) -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Nội dung chính được inject từ các view con -->
            @yield('content')
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>