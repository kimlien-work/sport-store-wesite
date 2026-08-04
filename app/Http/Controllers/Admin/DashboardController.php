<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product; // <-- THÊM DÒNG NÀY
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', 'delivered')->sum('total');
        $newOrders = Order::where('status', 'pending')->count();
        $totalUsers = User::where('role', 'customer')->count();
        $totalProducts = Product::count(); // <-- THÊM DÒNG NÀY
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 
            'newOrders', 
            'totalUsers', 
            'totalProducts',  // <-- THÊM VÀO COMPACT
            'recentOrders'
        ));
    }
}