<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Sesuaikan dengan model penjualan Anda
use App\Services\Order\OrderService;

class LaporanPenjualanController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function data()
    {
        $result = $this->orderService->getData();

        return datatables($result)
            ->addIndexColumn()
            ->editColumn('created_at', fn($q) => $this->renderTglTransaksi($q))
            ->editColumn('user', fn($q) => $this->renderUser($q))
            ->editColumn('products', fn($q) => $this->renderProduct($q))
            ->editColumn('quantity', fn($q) => $this->renderQuantity($q))
            ->editColumn('subtotal', fn($q) => $this->renderPrice($q))
            ->editColumn('status', fn($q) => $this->renderStatus($q))
            ->escapeColumns([])
            ->make(true);
    }

    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('created_at', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        $penjualan = $query->orderBy('created_at', 'desc')->get();

        return view('laporanpenjualan.index', compact('penjualan'));
    }

    protected function renderPrice($q)
    {
        return format_uang($q->orderDetail()->sum('subtotal'));
    }

    protected function renderStatus($q)
    {
        return '<span class="badge badge-' . $q->statusColor() . '">' . $q->status . '</span>';
    }

    protected function renderQuantity($q)
    {
        return $q->orderDetail()->sum('quantity');
    }


    protected function renderProduct($q)
    {
        $detail = $q->orderDetail()->with('product')->first();
        return $detail && $detail->product ? $detail->product->name : null;
    }

    protected function renderUser($q)
    {
        return $q->user->name;
    }

    protected function renderTglTransaksi($q)
    {
        return tanggal_indonesia($q->created_at, true, true);
    }
}
