<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sport Store - Giày & Đồ Thể Thao Chính Hãng')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; }
        .navbar { box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .navbar-brand img { height: 45px; }
        .cart-badge { position: absolute; top: 0; right: -5px; font-size: 0.65rem; }
        
        /* Hiệu ứng Hover cho Product Card */
        .product-card { border: none; border-radius: 12px; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.04); }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .product-card .card-img-top { border-top-left-radius: 12px; border-top-right-radius: 12px; height: 250px; object-fit: cover; }
        
        /* Dropdown tìm kiếm */
        #search-results { position: absolute; top: 100%; left: 0; right: 0; background: white; z-index: 1000; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px; display: none; max-height: 400px; overflow-y: auto; }
        .search-item { padding: 10px 15px; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 10px; color: #333; text-decoration: none; transition: background 0.2s;}
        .search-item:hover { background: #f8f9fa; }
        .search-item img { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }
        
        .footer { background: #1a1a2e; color: #b0b0c8; padding: 50px 0 20px; margin-top: 60px; }
        .footer h5 { color: #fff; margin-bottom: 20px; font-weight: 600; }
        .footer a { color: #b0b0c8; text-decoration: none; transition: 0.3s; }
        .footer a:hover { color: #4fc3f7; }
    </style>
    @stack('styles')
</head>
<body>

<!-- Header/Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-3" href="{{ route('home') }}">
            <i class="fas fa-running me-2"></i>SPORT STORE
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-medium">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                <!-- Thay cứng bằng logic lấy Categories từ View Composer sau -->
                <li class="nav-item"><a class="nav-link" href="#">Giày Thể Thao</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Quần Áo</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="#">Khuyến mãi hot</a></li>
            </ul>
            
            <!-- Ô Tìm kiếm thông minh -->
            <form class="d-flex position-relative me-3" action="{{ route('products.search') }}" method="GET" style="width: 300px;">
                <div class="input-group">
                    <input class="form-control" type="search" name="q" id="search-input" placeholder="Bạn tìm gì hôm nay..." autocomplete="off">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                </div>
                <!-- Box gợi ý -->
                <div id="search-results"></div>
            </form>

            <ul class="navbar-nav align-items-center">
                <!-- Giỏ hàng -->
                <li class="nav-item me-3">
                    <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                        <i class="bi bi-cart3 fs-4 text-dark"></i>
                        <span class="badge bg-danger rounded-pill cart-badge" id="cartCount">
                            {{ session('cart_count', 0) }}
                        </span>
                    </a>
                </li>
                
                <!-- Tài khoản -->
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4fc3f7&color=fff" class="rounded-circle" width="32" height="32" alt="">
                            <span class="text-dark fw-medium">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="{{ route('profile.index') }}"><i class="bi bi-person me-2"></i>Tài khoản của tôi</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('orders.index') }}"><i class="bi bi-bag-check me-2"></i>Đơn hàng mua</a></li>
                            @if(Auth::user()->role === 'admin')
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2 text-primary" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Trang quản trị</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="btn btn-outline-primary me-2" href="{{ route('login') }}">Đăng nhập</a></li>
                    <li class="nav-item"><a class="btn btn-primary" href="{{ route('register') }}">Đăng ký</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Nội dung chính -->
<main class="py-4 min-vh-100">
    @yield('content')
</main>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5 class="text-white"><i class="fas fa-running text-primary me-2"></i>SPORT STORE</h5>
                <p class="mt-3">Nền tảng mua sắm đồ thể thao chính hãng, uy tín hàng đầu. Cam kết chất lượng và dịch vụ tận tâm.</p>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h5>Về chúng tôi</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#">Giới thiệu</a></li>
                    <li class="mb-2"><a href="#">Tuyển dụng</a></li>
                    <li class="mb-2"><a href="#">Hệ thống cửa hàng</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Hỗ trợ khách hàng</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#">Chính sách đổi trả</a></li>
                    <li class="mb-2"><a href="#">Chính sách bảo hành</a></li>
                    <li class="mb-2"><a href="#">Hướng dẫn chọn size</a></li>
                </ul>
            </div>
            <div class="col-lg-3 mb-4">
                <h5>Liên hệ</h5>
                <p><i class="bi bi-geo-alt me-2"></i> 123 Đường Thể Thao, Hà Nội</p>
                <p><i class="bi bi-telephone me-2"></i> 1900 1234</p>
                <div class="mt-3">
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <div class="text-center pb-2">
            <small>&copy; {{ date('Y') }} Sport Store. All rights reserved.</small>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- SweetAlert2 cho thông báo -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Xử lý thông báo Flash từ Laravel bằng SweetAlert2
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    @if(session('success'))
        Toast.fire({ icon: "success", title: "{{ session('success') }}" });
    @endif
    @if(session('error'))
        Toast.fire({ icon: "error", title: "{{ session('error') }}" });
    @endif

    // Logic Live Search (Autocomplete)
    $(document).ready(function() {
        let timer;
        $('#search-input').on('keyup', function() {
            clearTimeout(timer);
            let query = $(this).val();
            let resultsBox = $('#search-results');
            
            if (query.length >= 2) {
                timer = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('products.autocomplete') }}", // Phải tạo route này
                        method: 'GET',
                        data: { q: query },
                        success: function(res) {
                            resultsBox.empty().show();
                            if(res.length > 0) {
                                res.forEach(item => {
                                    resultsBox.append(`
                                        <a href="/products/${item.slug}" class="search-item">
                                            <img src="${item.image}" alt="">
                                            <div>
                                                <div class="fw-bold">${item.name}</div>
                                                <small class="text-danger">${item.price_formatted}</small>
                                            </div>
                                        </a>
                                    `);
                                });
                            } else {
                                resultsBox.append('<div class="p-3 text-center text-muted">Không tìm thấy kết quả</div>');
                            }
                        }
                    });
                }, 300); // Đợi 300ms sau khi người dùng dừng gõ mới tìm kiếm
            } else {
                resultsBox.hide();
            }
        });

        // Ẩn box tìm kiếm khi click ra ngoài
        $(document).click(function(e) {
            if (!$(e.target).closest('form').length) {
                $('#search-results').hide();
            }
        });
    });
</script>
@stack('scripts')
</body>
</html>