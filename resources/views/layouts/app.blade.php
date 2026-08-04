<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - Sport Store</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --header-height: 60px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: #1a1a2e;
            color: #fff;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: #4a4a6a;
            border-radius: 10px;
        }
        
        .sidebar-brand {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .sidebar-brand i {
            font-size: 28px;
            color: #4fc3f7;
        }
        
        .sidebar-brand h3 {
            font-size: 20px;
            margin: 0;
            font-weight: 600;
            color: #fff;
        }
        
        .sidebar-brand small {
            font-size: 12px;
            color: #888;
            display: block;
            font-weight: 300;
        }
        
        .sidebar-menu {
            padding: 15px 0;
        }
        
        .sidebar-menu .menu-label {
            padding: 10px 20px;
            font-size: 11px;
            text-transform: uppercase;
            color: #6c6c8a;
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #b0b0c8;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            gap: 12px;
            font-size: 14px;
        }
        
        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
            border-left-color: #4fc3f7;
        }
        
        .sidebar-menu a.active {
            background: rgba(79, 195, 247, 0.15);
            color: #4fc3f7;
            border-left-color: #4fc3f7;
        }
        
        .sidebar-menu a i {
            width: 20px;
            font-size: 16px;
        }
        
        .sidebar-menu a .badge {
            margin-left: auto;
            background: #e74c3c;
            color: #fff;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 20px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        /* Header */
        .top-header {
            background: #fff;
            padding: 0 30px;
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e9ecef;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .top-header .toggle-sidebar {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }
        
        .top-header .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .top-header .user-info .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #4fc3f7;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 16px;
        }
        
        .top-header .user-info .user-name {
            font-weight: 500;
            color: #333;
        }
        
        .top-header .user-info .user-role {
            font-size: 12px;
            color: #888;
        }
        
        /* Content Area */
        .content-area {
            padding: 25px 30px;
        }
        
        /* Stats Cards */
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 12px;
        }
        
        .stat-card .stat-icon.primary { background: #e3f2fd; color: #1976d2; }
        .stat-card .stat-icon.success { background: #e8f5e9; color: #388e3c; }
        .stat-card .stat-icon.warning { background: #fff3e0; color: #f57c00; }
        .stat-card .stat-icon.danger { background: #fce4ec; color: #c62828; }
        .stat-card .stat-icon.info { background: #e0f7fa; color: #00838f; }
        
        .stat-card .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
        }
        
        .stat-card .stat-label {
            font-size: 14px;
            color: #888;
            margin-top: 4px;
        }
        
        .stat-card .stat-change {
            font-size: 13px;
            margin-top: 8px;
        }
        
        .stat-card .stat-change.up { color: #388e3c; }
        .stat-card .stat-change.down { color: #c62828; }
        
        /* Tables */
        .table-container {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid #e9ecef;
        }
        
        .table-container .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .table-container .table-header h5 {
            margin: 0;
            font-weight: 600;
            color: #1a1a2e;
        }
        
        .table th {
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #e9ecef;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .badge-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-status.pending { background: #fff3e0; color: #e65100; }
        .badge-status.confirmed { background: #e3f2fd; color: #0d47a1; }
        .badge-status.shipping { background: #e0f7fa; color: #006064; }
        .badge-status.delivered { background: #e8f5e9; color: #1b5e20; }
        .badge-status.cancelled { background: #fce4ec; color: #b71c1c; }
        
        /* Form Styles */
        .form-container {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid #e9ecef;
        }
        
        .form-container .form-title {
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .form-label {
            font-weight: 500;
            color: #444;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px 14px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #4fc3f7;
            box-shadow: 0 0 0 3px rgba(79, 195, 247, 0.2);
        }
        
        .btn {
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #4fc3f7;
            border-color: #4fc3f7;
            color: #fff;
        }
        
        .btn-primary:hover {
            background: #29b6f6;
            border-color: #29b6f6;
        }
        
        .btn-success {
            background: #66bb6a;
            border-color: #66bb6a;
        }
        
        .btn-danger {
            background: #ef5350;
            border-color: #ef5350;
        }
        
        .btn-warning {
            background: #ffa726;
            border-color: #ffa726;
            color: #fff;
        }
        
        /* Variant rows */
        .variant-row {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 8px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .top-header .toggle-sidebar {
                display: block;
            }
            
            .content-area {
                padding: 15px;
            }
            
            .stat-card .stat-number {
                font-size: 22px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-store"></i>
        <div>
            <h3>Sport Store</h3>
            <small>Admin Panel</small>
        </div>
    </div>
    
    <div class="sidebar-menu">
        <div class="menu-label">Tổng quan</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>
        
        <div class="menu-label">Quản lý</div>
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Sản phẩm
        </a>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i> Danh mục
        </a>
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i> Đơn hàng
            <span class="badge" id="newOrdersBadge">0</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Người dùng
        </a>
        
        <div class="menu-label">Tiện ích</div>
        <a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
            <i class="fas fa-image"></i> Banner
        </a>
        <a href="{{ route('admin.coupons.index') }}" class="{{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
            <i class="fas fa-gift"></i> Mã giảm giá
        </a>
        <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="fas fa-star"></i> Đánh giá
        </a>
        
        <div class="menu-label">Hệ thống</div>
        <a href="{{ route('profile.edit') }}">
            <i class="fas fa-user-cog"></i> Hồ sơ
        </a>
        <a href="#" onclick="document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Đăng xuất
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Top Header -->
    <div class="top-header">
        <div>
            <button class="toggle-sidebar" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <div class="user-info">
            <div>
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">
                    <span class="badge bg-primary">{{ Auth::user()->role }}</span>
                </div>
            </div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </div>
    
    <!-- Content Area -->
    <div class="content-area">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @yield('content')
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle sidebar
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }
    
    // Close sidebar on outside click (mobile)
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.querySelector('.toggle-sidebar');
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
    
    // Update new orders count
    function updateNewOrders() {
        fetch('{{ route("admin.orders.new-count") }}')
            .then(res => res.json())
            .then(data => {
                const badge = document.getElementById('newOrdersBadge');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'inline';
                } else {
                    badge.style.display = 'none';
                }
            })
            .catch(err => console.log(err));
    }
    
    // Update every 30 seconds
    if (document.getElementById('newOrdersBadge')) {
        updateNewOrders();
        setInterval(updateNewOrders, 30000);
    }
    
    // Confirm delete
    function confirmDelete(message = 'Bạn có chắc chắn muốn xóa?') {
        return confirm(message);
    }
</script>
@stack('scripts')
</body>
</html>