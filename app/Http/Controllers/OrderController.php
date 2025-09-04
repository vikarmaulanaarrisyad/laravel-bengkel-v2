<?php

namespace App\Http\Controllers;

use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\Order\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('orders.index');
    }

    public function data()
    {
        $result = $this->orderService->getData();

        return datatables($result)
            ->addIndexColumn()
            ->editColumn('tracking_number', fn($q) => $this->renderTrackingNumber($q))
            ->editColumn('shipping_cost', fn($q) => $this->renderShippingCost($q))
            ->editColumn('invoice_number', fn($q) => $this->renderInvoiceNumber($q))
            ->editColumn('created_at', fn($q) => $this->renderTglTransaksi($q))
            ->editColumn('status', fn($q) => $this->renderStatus($q))
            ->editColumn('amount', fn($q) => $this->renderPrice($q))
            ->editColumn('action', fn($q) => $this->renderActionButtons($q))
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $result = $this->orderService->show($id);

        if ($result->isEmpty()) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return datatables($result)
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    protected function renderPrice($q)
    {
        return format_uang($q->amount);
    }

    protected function renderStatus($q)
    {
        return '<span class="badge badge-' . $q->statusColor() . '">' . $q->status . '</span>';
    }

    protected function renderInvoiceNumber($q)
    {
        return '<span class="badge badge-success">' . $q->invoice_number . '</span>';
    }

    protected function renderShippingCost($q)
    {
        return format_uang($q->shipping_cost);
    }

    protected function renderTrackingNumber($q)
    {
        return '<span class="badge badge-success">' . $q->tracking_number  . '</span>';
    }

    protected function renderTglTransaksi($q)
    {
        return tanggal_indonesia($q->created_at, true, true);
    }

    protected function renderActionButtons($q)
    {
        $aksi = '';

        // Tombol Detail jika user memiliki izin
        if (Auth::user()->hasPermissionTo('Orders Show') || Auth::user()->hasPermissionTo('Orders Edit')) {
            $aksi .= '
            <button title="Detail" onclick="showDetail(`' . route('orders.show', $q->id) . '`)" class="btn btn-xs btn-primary mr-1">
                <i class="fas fa-eye"></i>
            </button>
        ';
        }

        // Tombol Download PDF jika user memiliki izin
        if (Auth::user()->hasPermissionTo('Orders Index')) {
            $aksi .= '
            <a href="' . route('orders.download', $q->id) . '" title="Download PDF" class="btn btn-xs btn-danger">
                <i class="fas fa-file-pdf"></i>
            </a>
        ';
        }

        // Tombol Input Nomor Resi (buka modal)
        if (Auth::user()->hasPermissionTo('Orders Edit')) {
            $aksi .= '
            <button title="Input Resi" class="btn btn-xs btn-success" onclick="openResiModal(' . $q->id . ')">
                <i class="fas fa-barcode"></i>
            </button>
        ';
        }
        // if (Auth::user()->hasPermissionTo('Orders Edit')) {
        //     $aksi .= '
        //         <a href="' . route('orders.fake-resi.form', $q->id) . '" class="btn btn-xs btn-success">
        //             <i class="fas fa-barcode"></i>
        //         </a>
        //     ';
        // }



        return $aksi;
    }


    protected function renderPathImage($q)
    {
        if (!empty($q->path_image)) {
            return '<img src="' . Storage::url($q->path_image) . '" alt="Image" class="img-thumbnail" style="width: 75px; height: 75px;">';
        }
        return '<span class="text-muted">No Image</span>';
    }

    public function getOrderDetails($orderId)
    {
        $order = Order::with(['orderDetail.product', 'reviews'])->findOrFail($orderId);
        // return $order;
        return response()->json([
            'order' => $order
        ]);
    }

    public function generatePdf($id)
    {
        // Ambil data order berdasarkan ID
        $orders = Order::with(['orderDetail.product'])->where('id', $id)->firstOrFail();

        // Untuk sementara, tampilkan view secara langsung
        // return view('pdf.order-report', compact('orders'));

        // Jika sudah benar, gunakan kode di bawah untuk menghasilkan PDF
        $pdf = Pdf::loadView('pdf.order-report', compact('orders'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('order-report.pdf');
    }

    public function updateResi(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'awb' => 'required|string',
            'courier' => 'required|string'
        ]);

        $client = new Client();

        $response = $client->request('POST', env('RAJA_ONGKIR_API'), [
            'headers' => [
                'accept' => 'application/json',
                // 'key' => '1vV2oHQwc7bd6d0953131ef4qXGm7eXo',
                // 'key' => '1fd969e8011cefb27d112188e52248c4',
                'key' => env('RAJAONGKIR_API_KEY'),
            ],
            'form_params' => [
                'awb' => '0637132400441624',
                'courier' => 'jne'
            ]
        ]);

        return $response;

        try {
            // Kirim request ke API RajaOngkir
            $response = $client->request('POST', env('RAJA_ONGKIR_API'), [
                'headers' => [
                    'accept' => 'application/json',
                    // 'key' => '1vV2oHQwc7bd6d0953131ef4qXGm7eXo',
                    // 'key' => '1fd969e8011cefb27d112188e52248c4',
                    'key' => env('RAJAONGKIR_API_KEY'),
                ],
                'form_params' => [
                    'awb' => $request->input('awb'),
                    'courier' => $request->input('courier')
                ]
            ]);

            // Ambil data dari response
            $body = json_decode($response->getBody(), true);
            $summary = $body['data']['summary'] ?? [];
            $details = $body['data']['details'] ?? [];
            $delivery = $body['data']['delivery_status'] ?? [];
            $manifest = $body['data']['manifest'] ?? [];

            // Ambil order berdasarkan order_id
            $order = Order::findOrFail($request->order_id);


            // Update data ke database
            $order->update([
                'awb' => $request->awb,
                // 'awb' => $awb,
                'courier' => $request->courier,
                'service_code' => $summary['service_code'] ?? null,
                'status_summary' => $summary['status'] ?? 'PENDING',

                'waybill_number' => $details['waybill_number'] ?? null,
                'waybill_date' => $details['waybill_date'] ?? null,
                'waybill_time' => $details['waybill_time'] ?? null,
                'weight' => $details['weight'] ?? null,
                'origin' => $details['origin'] ?? null,
                'destination' => $details['destination'] ?? null,

                'shipper_name' => $details['shipper_name'] ?? null,
                'shipper_address1' => $details['shipper_address1'] ?? null,
                'shipper_address2' => $details['shipper_address2'] ?? null,
                'shipper_address3' => $details['shipper_address3'] ?? null,
                'shipper_city' => $details['shipper_city'] ?? null,

                'receiver_name' => $details['receiver_name'] ?? null,
                'receiver_address1' => $details['receiver_address1'] ?? null,
                'receiver_address2' => $details['receiver_address2'] ?? null,
                'receiver_address3' => $details['receiver_address3'] ?? null,
                'receiver_city' => $details['receiver_city'] ?? null,

                'pod_receiver' => $delivery['pod_receiver'] ?? null,
                'pod_date' => $delivery['pod_date'] ?? null,
                'pod_time' => $delivery['pod_time'] ?? null,

                'manifest' => json_encode($manifest)
            ]);

            return redirect()->back()->with('success', 'Nomor resi berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal melacak: ' . $e->getMessage()]);
        }
    }

    public function simulateTracking($id)
    {
        $order = Order::findOrFail($id);

        $simulatedTracking = [
            [
                'manifest_date' => now()->subDays(2)->format('Y-m-d'),
                'manifest_description' => 'Paket telah diterima oleh kurir.',
            ],
            [
                'manifest_date' => now()->subDay()->format('Y-m-d'),
                'manifest_description' => 'Paket sedang dalam perjalanan.',
            ],
            [
                'manifest_date' => now()->format('Y-m-d'),
                'manifest_description' => 'Paket telah sampai di tujuan.',
            ],
        ];

        $order->update([
            'status' => 'DELIVERED',
            'tracking_data' => $simulatedTracking
        ]);

        return back()->with('success', 'Tracking simulasi berhasil dibuat.');
    }

    // Fungsi generate nomor resi palsu sesuai kurir
    private function generateFakeAWB($courier)
    {
        $prefixes = [
            'jne' => 'JNE',
            'jnt' => 'JNT',
            'tiki' => 'TIKI',
            'sicepat' => 'SCP',
            'anteraja' => 'ATR',
            'wahana' => 'WHN',
        ];

        $prefix = $prefixes[strtolower($courier)] ?? 'SIM';
        return $prefix . strtoupper(Str::random(3)) . rand(100000000, 999999999);
    }

    // Fungsi buat nomor resi palsu + simulasikan tracking
    public function createFakeResiAndTracking(Request $request)
    {
        // Validasi input minimal
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'courier' => 'required|string'
        ]);

        $order = Order::findOrFail($request->order_id);

        // Generate nomor resi palsu
        $fakeAwb = $this->generateFakeAWB($request->courier);

        // Simulasi tracking data
        $simulatedTracking = [
            [
                'manifest_date' => now()->subDays(3)->format('Y-m-d H:i:s'),
                'manifest_description' => 'Paket diterima oleh kurir di gudang.',
            ],
            [
                'manifest_date' => now()->subDays(2)->format('Y-m-d H:i:s'),
                'manifest_description' => 'Paket sedang dalam perjalanan ke kota tujuan.',
            ],
            [
                'manifest_date' => now()->subDay()->format('Y-m-d H:i:s'),
                'manifest_description' => 'Paket telah sampai di kota tujuan dan sedang proses pengiriman.',
            ],
            [
                'manifest_date' => now()->format('Y-m-d H:i:s'),
                'manifest_description' => 'Paket telah diterima oleh penerima.',
            ],
        ];

        // Update data order
        $order->update([
            'awb' => $fakeAwb,
            'courier' => $request->courier,
            'status_summary' => 'DELIVERED',
            'tracking_data' => json_encode($simulatedTracking),  // Pastikan kolom tracking_data di DB text/json
            'manifest' => json_encode($simulatedTracking)       // Kalau kamu pakai kolom manifest juga
        ]);

        return back()->with('success', "Nomor resi palsu ($fakeAwb) berhasil dibuat dan tracking disimulasikan.");
    }

    public function showFakeResiForm($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('orders.fake_resi_form', compact('order'));
    }
}
