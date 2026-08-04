<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Kiểm tra user đã mua sản phẩm này chưa (đã giao)
        $hasBought = Auth::user()->orders()
            ->where('status', 'delivered')
            ->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })
            ->exists();

        if (!$hasBought) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm đã mua.');
        }

        // Kiểm tra đã đánh giá chưa
        $existing = Review::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();
        if ($existing) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}