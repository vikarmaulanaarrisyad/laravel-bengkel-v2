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
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $existingReview = Review::where('user_id', Auth::id())
            ->where('order_id', $request->order_id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan review untuk produk ini.');
        }
        Review::create([
            'user_id' => Auth::id(),
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'content' => $request->comment, // Ganti 'review' jadi 'content'
        ]);

        // Jika semua produk stok cukup, pembayaran berhasil
        $notification = [
            'message' => 'Review berhasil dikirim!',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
}
