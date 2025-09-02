<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Sesuaikan dengan model penjualan Anda

class LaporanPenjualanController extends Controller
{
    // Pastikan tidak ada middleware permission di sini

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
}
