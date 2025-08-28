<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Cart::total() > 0) {
                $carts = Cart::content();
                $cartQty = Cart::count();
                $total = Cart::total();
                return view('frontend.checkout', compact(
                    'carts',
                    'cartQty',
                    'total',
                ));
            } else {
                return redirect()->to('/');
            }
        } else {
            $notification = array(
                'message' => 'Silahkan Login Terlebih Dahulu',
                'error' => 'Silahkan Login Terlebih Dahulu'
            );
            return redirect()->route('login')->with($notification);
        }
    }

    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     // Validasi Input
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'phone' => 'required|string|max:15',
    //         'address' => 'required|string|max:255',
    //         'order_notes' => 'nullable|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $validator->errors()->first(),
    //         ], 400);
    //     }

    //     DB::beginTransaction();
    //     try {
    //         // Ambil data cart
    //         $carts = Cart::content();
    //         $totalAmount = (int) str_replace('.', '', Cart::subtotal());

    //         // Simpan data order
    //         $orderId = Order::insertGetId([
    //             'user_id' => Auth::id(),
    //             'name' => $request->name,
    //             'phone' => $request->phone,
    //             'address' => $request->address,
    //             'note' => $request->order_notes,
    //             'amount' => $totalAmount,
    //             'invoice_number' => 'INV' . rand(100000000000, 999999999999999),
    //             'status' => 'Pending',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //             // 'tracking_number' => 'RESI' . strtoupper(uniqid()), // Contoh: RESI664F7A1DB5E2A
    //             // 'shipping_status' => 'Menunggu Konfirmasi',
    //         ]);

    //         // Simpan detail order
    //         foreach ($carts as $cart) {
    //             OrderDetail::insert([
    //                 'order_id' => $orderId,
    //                 'product_id' => $cart->id,
    //                 'quantity' => $cart->qty,
    //                 'price' => $cart->price,
    //                 'subtotal' => $cart->price * $cart->qty,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ]);
    //         }

    //         DB::commit(); // Commit transaction

    //         // Hapus keranjang
    //         Cart::destroy();

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Pesanan berhasil diproses!',
    //             'redirect' => url('/checkout/history'), // URL untuk redirect
    //         ], 200);
    //     } catch (\Exception $e) {
    //         DB::rollBack(); // Rollback jika ada error

    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function store(Request $request)
    {
        // Validasi Input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'order_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $province = Province::where('id', $request->provinces)->first();
        $regencies = Regency::where('id', $request->regencies)->first();
        $districts = District::where('id', $request->districts)->first();
        $villages = Village::where('id', $request->villages)->first();
        // dd($province, $regencies, $districts);

        // Ambil data cart
        $carts = Cart::content();
        $totalAmount = (int) str_replace('.', '', Cart::subtotal());

        // ✅ Cek stok produk terlebih dahulu
        foreach ($carts as $cart) {
            $product = \App\Models\Product::find($cart->id); // Ganti dengan model produk Anda
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Produk dengan ID {$cart->id} tidak ditemukan.",
                ], 404);
            }

            if ($cart->qty > $product->stock) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Jumlah produk '{$product->name}' yang dibeli melebihi stok. Stok tersedia: {$product->stock}.",
                ], 400);
            }
        }


        DB::beginTransaction();
        try {
            // Simpan data order
            $orderId = Order::insertGetId([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'note' => $request->order_notes,
                'amount' => $totalAmount,
                'invoice_number' => 'INV' . rand(100000000000, 999999999999999),
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
                'provinces' => $province->name,
                'regencies' => $regencies->name,
                'districts' => $districts->name,
                'villages' => $villages->name,
            ]);

            // Simpan detail order dan kurangi stok
            foreach ($carts as $cart) {
                OrderDetail::insert([
                    'order_id' => $orderId,
                    'product_id' => $cart->id,
                    'quantity' => $cart->qty,
                    'price' => $cart->price,
                    'subtotal' => $cart->price * $cart->qty,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Kurangi stok produk
                $product = \App\Models\Product::find($cart->id);
                $product->decrement('stock', $cart->qty);
            }

            DB::commit();

            // Hapus keranjang
            Cart::destroy();

            return response()->json([
                'status' => 'success',
                'message' => 'Pesanan berhasil diproses!',
                'redirect' => url('/checkout/history'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function checkoutStore(Request $request)
    {
        $id_order = $request->id_order;
        $data = json_decode($request->get('json'));
        Order::findOrfail($id_order)->update([
            'status' => 'Success',
            'payment_type' => $data->payment_type,
            'transaction_id' => $data->transaction_id
        ]);

        $notification = [
            'message' => 'Pembayaran Success',
            'alert-type' => 'success',
        ];

        return redirect()->route('dashboard')->with($notification);
    }

    public function history()
    {
        $userId = Auth::user()->id;

        $orders = Order::with(['orderDetail.product'])->where('user_id', $userId)->get();

        return view('frontend.historyorder', compact('orders'));
    }

    public function getOrderDetails($orderId)
    {
        $order = Order::with(['orderDetail'])->findOrFail($orderId);

        return response()->json([
            'order' => $order
        ]);
    }
}
