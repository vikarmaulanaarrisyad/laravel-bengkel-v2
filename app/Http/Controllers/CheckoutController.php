<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product; // Pastikan model Product di-import
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        if (Auth::check()) {
            if (Cart::count() > 0) {
                $carts = Cart::content();
                return view('frontend.checkout', compact('carts'));
            } else {
                return redirect()->to('/')->with('info', 'Keranjang belanja Anda kosong.');
            }
        } else {
            return redirect()->route('login')->with('error', 'Silahkan Login Terlebih Dahulu');
        }
    }

    /**
     * Memproses dan menyimpan pesanan baru.
     */
    public function store(Request $request)
    {
        // Validasi input dari form, termasuk ongkir dan total akhir
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'notes' => 'nullable|string',
            'shipping_cost' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:1', // Total harus lebih besar dari 0
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data yang Anda masukkan tidak valid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $carts = Cart::content();
        if ($carts->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Keranjang belanja Anda kosong.'], 400);
        }

        // Memulai transaksi database untuk memastikan konsistensi data
        DB::beginTransaction();
        try {
            // Cek stok sebelum membuat pesanan
            foreach ($carts as $cart) {
                $product = Product::find($cart->id);
                if (!$product || $cart->qty > $product->stock) {
                    DB::rollBack(); // Batalkan transaksi jika stok tidak cukup
                    return response()->json([
                        'status' => 'error',
                        'message' => "Stok produk '{$cart->name}' tidak mencukupi. Sisa stok: " . ($product->stock ?? 0),
                    ], 400);
                }
            }

            // Simpan data pesanan ke tabel 'orders'
            $order = Order::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'address' => $request->address,
                'note' => $request->notes, // Menggunakan 'notes' sesuai name di form
                'amount' => $request->grand_total, // Total akhir yang sudah termasuk ongkir
                'shipping_cost' => $request->shipping_cost, // Menyimpan biaya ongkir
                'invoice_number' => 'INV' . strtoupper(uniqid()),
                'status' => 'Pending', // Status awal pesanan
            ]);

            // Simpan setiap item di keranjang ke tabel 'order_details'
            foreach ($carts as $cart) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->id,
                    'quantity' => $cart->qty,
                    'price' => $cart->price,
                    'subtotal' => $cart->subtotal,
                ]);

                // Kurangi stok produk
                Product::find($cart->id)->decrement('stock', $cart->qty);
            }

            DB::commit(); // Konfirmasi semua perubahan jika berhasil
            Cart::destroy(); // Kosongkan keranjang setelah checkout berhasil

            return response()->json([
                'status' => 'success',
                'message' => 'Pesanan berhasil dibuat!',
                'redirect' => url('/checkout/history'), // URL untuk redirect
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika terjadi error
            // Log::error($e->getMessage()); // Opsional: catat error ke log
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan internal saat memproses pesanan.',
                 'debug' => $e->getMessage() // Untuk debugging
            ], 500);
        }
    }

    /**
     * Menampilkan riwayat pesanan pengguna.
     */
    public function history()
    {
        $userId = Auth::id();
        $orders = Order::with('orderDetail.product')
                        ->where('user_id', $userId)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('frontend.historyorder', compact('orders'));
    }

    /**
     * Mengambil detail pesanan via AJAX.
     */
    public function getOrderDetails($orderId)
    {
        $order = Order::with(['orderDetail.product'])->findOrFail($orderId);
        return response()->json(['order' => $order]);
    }

    /**
     * Callback setelah pembayaran Midtrans.
     */
    public function checkoutStore(Request $request)
    {
        $id_order = $request->id_order;
        $data = json_decode($request->get('json'));
        Order::findOrFail($id_order)->update([
            'status' => 'Success',
            'payment_type' => $data->payment_type,
            'transaction_id' => $data->transaction_id
        ]);

        return redirect()->route('dashboard')->with('success', 'Pembayaran Berhasil!');
    }
}

