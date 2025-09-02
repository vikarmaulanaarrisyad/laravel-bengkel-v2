<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function detailProduct($slug)
{
    $product = \App\Models\Product::with('category')->where('slug', $slug)->firstOrFail();

    // Ambil review dengan relasi user
    $reviews = $product->reviews()->with('user')->latest()->get();

    return view('frontend.detailproduct', compact('product', 'reviews'));
}

}
