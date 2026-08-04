<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code|max:50',
            'discount_type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'expiry' => 'nullable|date',
        ]);

        Coupon::create($request->all());
        return redirect()->route('admin.coupons.index')->with('success', 'Mã giảm giá đã được tạo.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'expiry' => 'nullable|date',
        ]);

        $coupon->update($request->all());
        return redirect()->route('admin.coupons.index')->with('success', 'Mã giảm giá đã được cập nhật.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Mã giảm giá đã được xóa.');
    }
}