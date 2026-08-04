<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
 
// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
 
// ========================================================
// PUBLIC ROUTES
// ========================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
 
// Tìm kiếm & Autocomplete
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/autocomplete', [ProductController::class, 'autocomplete'])->name('products.autocomplete');
 
// ========================================================
// AUTHENTICATED ROUTES
// ========================================================
Route::middleware('auth')->group(function () {
 
    // Dashboard (Breeze)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');
 
    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');
        Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('destroy');
    });
 
    // Giỏ hàng
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::patch('/update/{key}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{key}', [CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'count'])->name('count');
    });
 
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
 
    // Đơn hàng
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::patch('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });
 
    // Wishlist
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/add/{product}', [WishlistController::class, 'add'])->name('add');
        Route::delete('/remove/{product}', [WishlistController::class, 'remove'])->name('remove');
    });
 
    // Đánh giá sản phẩm
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});
 
// ========================================================
// ADMIN ROUTES
// ========================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
 
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
 
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('products', AdminProductController::class);
    Route::resource('orders', AdminOrderController::class)->except(['create', 'store', 'destroy']);
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
 
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
 
    Route::resource('coupons', AdminCouponController::class);
    Route::resource('banners', AdminBannerController::class);
    Route::resource('reviews', AdminReviewController::class)->only(['index', 'destroy']);
});
Route::get('/orders/new-count', [AdminOrderController::class, 'newCount'])->name('admin.orders.new-count');
require __DIR__.'/auth.php';