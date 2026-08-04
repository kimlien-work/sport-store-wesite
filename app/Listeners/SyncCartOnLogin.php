<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\CartService; // Nhớ import Service của bạn

class SyncCartOnLogin
{
    protected $cartService;

    // Inject CartService vào Listener
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // Hàm này sẽ tự động chạy khi User đăng nhập thành công
    public function handle(Login $event): void
    {
        $this->cartService->syncOnLogin();
    }
}
