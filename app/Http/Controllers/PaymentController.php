<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product; // Pastikan model Product sudah ada
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function getSnapToken(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = $request->id;

        // Cek apakah orderId valid dan data order ada
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Siapkan data untuk transaksi
        $transactionDetails = [
            'order_id' => $order->invoice_number,
            'gross_amount' => $order->amount,
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => [
                'first_name' => $order->name,
                'email' => $order->email,
                'phone' => $order->phone,
            ],
        ];

        try {
            // Dapatkan snap token dari Midtrans
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function pay($id)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $order = Order::where('status', 'Pending')
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found or already processed'], 404);
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $order->amount
            ),

            'customer_details' => array(
                'first_name' => $order->name,
                'phone' => $order->phone
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('frontend.historyorderdetail', compact('snapToken'));
    }

    public function paymentSuccess(Request $request)
    {
        $id_order = $request->id_order;
        $data = json_decode($request->get('json'));

        $order = Order::findOrfail($id_order);

        // Update status pembayaran
        $order->update([
            'status' => 'Success',
            'payment_type' => $data->payment_type,
            'transaction_id' => $data->transaction_id
        ]);

        // Cek dan update stok produk
        foreach ($order->orderDetail as $item) {
            $product = Product::find($item->product_id);
            if ($product && $product->stock >= $item->quantity) {
                // Kurangi stok produk
                // $product->update([
                //     'stock' => $product->stock - $item->quantity
                // ]);
            } else {
                // Jika stok kurang dari 1, batalkan pembayaran
                $order->update([
                    'status' => 'Failed',
                    'payment_type' => 'Failed',
                    'transaction_id' => null
                ]);

                $notification = [
                    'message' => 'Pembayaran Gagal, Stok Tidak Cukup!',
                    'alert-type' => 'error',
                ];

                return redirect()->route('dashboard')->with($notification);
            }
        }

        // Jika semua produk stok cukup, pembayaran berhasil
        $notification = [
            'message' => 'Pembayaran Berhasil',
            'alert-type' => 'success',
        ];

        return redirect()->route('dashboard')->with($notification);
    }
}
