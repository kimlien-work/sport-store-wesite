# Sport Store Website

Website bán đồ thể thao trực tuyến được xây dựng bằng **Laravel 12**, hỗ trợ đầy đủ chức năng dành cho khách hàng và quản trị viên.

## 🚀 Tính năng chính

### Phía khách hàng (Frontend)
- Trang chủ với banner, danh mục, sản phẩm nổi bật
- Xem sản phẩm theo danh mục
- Chi tiết sản phẩm (hình ảnh, biến thể size/màu, đánh giá)
- Tìm kiếm sản phẩm + Autocomplete
- Giỏ hàng (thêm, sửa số lượng, xóa)
- Wishlist (danh sách yêu thích)
- Thanh toán (Checkout)
- Quản lý đơn hàng (xem lịch sử, hủy đơn)
- Đánh giá sản phẩm
- Đăng ký / Đăng nhập / Quản lý hồ sơ cá nhân
- Áp dụng mã giảm giá (Coupon)

### Phía quản trị (Admin)
- Dashboard thống kê
- Quản lý danh mục (CRUD)
- Quản lý sản phẩm (CRUD, hình ảnh, biến thể)
- Quản lý đơn hàng (cập nhật trạng thái)
- Quản lý người dùng
- Quản lý mã giảm giá (Coupon)
- Quản lý Banner
- Quản lý đánh giá sản phẩm

## 🛠️ Công nghệ sử dụng

| Thành phần       | Công nghệ                          |
|------------------|------------------------------------|
| Backend          | Laravel 12, PHP 8.2+               |
| Frontend         | Tailwind CSS, Alpine.js, Vite      |
| Database         | MySQL / SQLite                     |
| Authentication   | Laravel Breeze                     |
| Phân quyền       | Spatie Laravel Permission          |
| Xử lý ảnh        | Intervention Image                 |
| Xuất Excel       | Maatwebsite Excel                  |

## 📁 Cấu trúc chính
app/
├── Http/Controllers/
│   ├── Admin/              # Controller quản trị
│   ├── Auth/               # Xác thực
│   ├── CartController.php
│   ├── CheckoutController.php
│   ├── ProductController.php
│   └── ...
├── Models/
│   ├── Product.php
│   ├── Category.php
│   ├── Order.php
│   ├── Cart.php
│   ├── Wishlist.php
│   ├── Coupon.php
│   ├── Banner.php
│   └── Review.php
database/
├── migrations/             # Các bảng: products, orders, variants...
└── seeders/                # Dữ liệu mẫu
resources/views/            # Blade templates
routes/web.php              # Định nghĩa routes

🔐 Tài khoản mặc định
Vai trò      Email                      Mật khẩu
Admin        admin@sportstore.com       password
Khách hàng   user@test.com              password

📌 Ghi chú
Dự án sử dụng product variants (size, màu sắc...).
Hỗ trợ coupon giảm giá theo phần trăm hoặc số tiền cố định.
Có tính năng wishlist và đánh giá sản phẩm.
Admin được bảo vệ bằng middleware admin.
