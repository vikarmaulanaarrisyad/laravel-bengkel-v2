<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChartController extends Controller
{
    public function addToCart1(Request $request, $id)
    {
        $product = Product::findOrfail($id);

        Cart::add([
            'id' => $id,
            'name' => $request->product_name,
            'qty' => $request->qty,
            'price' => $product->price,
            'weight' => 1,
            'options' => [
                'image' => Storage::url($product->path_image)
            ]
        ]);

        return response()->json(['success' => 'Data berhasil ditambahkan ke Keranjang']);
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        // Tambahkan produk ke keranjang
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $product->price,
            'weight' => 1,
            'options' => [
                'image' => Storage::url($product->path_image)
            ]
        ]);

        return response()->json(['success' => 'Data berhasil ditambahkan ke Keranjang']);
    }


    public function addMiniCart()
    {
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal =  Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => $cartTotal
        ));
    }

    public function removeMiniCart($rowId)
    {
        Cart::remove($rowId);

        return response()->json(['success' => 'Data Keranjang Berhasil Dihapus']);
    }

    public function incrementMyCart($rowId)
    {
        $row = Cart::get($rowId);
        Cart::update($rowId, $row->qty + 1);
        return response()->json(['success' => 'Data Qty Berhasil Ditambahkan']);
    }

    public function decrementMyCart($rowId)
    {
        $row = Cart::get($rowId);
        Cart::update($rowId, $row->qty - 1);
        return response()->json(['success' => 'Data Qty Berhasil Ditambahkan']);
    }

    public function updateQuantity($rowId, $quantity)
    {
        $cartItem = Cart::get($rowId);
        if ($cartItem) {
            Cart::update($rowId, $quantity);
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'Item not found in the cart']);
    }

}
