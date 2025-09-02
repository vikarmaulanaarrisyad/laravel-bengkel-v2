<?php

namespace App\Http\Controllers\Konfigurasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class StokofflineController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('konfigurasi.Stokoffline.index', compact('products'));
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('konfigurasi.Stokoffline.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stok_offline' => 'required|integer|min:0',
        ]);
        $product = Product::findOrFail($id);
        $product->stok_offline = $request->stok_offline;
        $product->save();
        return redirect()->route('stokoffline.index')->with('success', 'Stok offline berhasil diupdate');
    }

    public function transaksiForm()
    {
        $products = Product::all();
        return view('konfigurasi.Stokoffline.transaksi', compact('products'));
    }

    public function transaksi(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);
        $product = Product::findOrFail($request->product_id);
        if ($product->stok_offline < $request->qty) {
            return redirect()->back()->with('error', 'Stok offline tidak cukup!');
        }
        $product->stok_offline -= $request->qty;
        $product->save();
        return redirect()->route('stokoffline.index')->with('success', 'Transaksi offline berhasil disimpan dan stok berkurang.');
    }
}

