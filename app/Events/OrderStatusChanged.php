<?php

namespace App\Events;

use App\Models\Order; // Đừng quên import Model Order
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged
{
    use Dispatchable, SerializesModels;

    public Order $order; 

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}