<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Mail\OrderStatusMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderStatusNotification implements ShouldQueue
{
    public function handle(OrderStatusChanged $event)
    {
        $order = $event->order;
        Mail::to($order->user->email)->queue(new OrderStatusMail($order));
    }
}