<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     if (!auth()->user()->hasVerifiedEmail()) {
    //         return redirect()->route('verification.notice');
    //     }

    //     // Cek apakah user yang login memiliki role 'Customer'
    //     if (auth()->user()->hasRole('Customer')) {
    //         if (!auth()->user()->hasVerifiedEmail()) {
    //             return redirect()->route('verification.notice');
    //         }

    //         // Arahkan ke URL '/'
    //         return redirect('/');
    //     }

    //     $pesananDiterima = Order::where('status', 'Pending')->count();
    //     $pesananSuccess = Order::where('status', 'Success')->count();

    //     $totalPendapatanHariIni = Order::where('status', 'Success')
    //         ->whereDate('created_at', Carbon::today()) // Menggunakan Carbon untuk tanggal hari ini
    //         ->sum('amount');
    //     $pendapatanBulanIni = Order::where('status', 'Success')
    //         ->whereMonth('created_at', now()->month)
    //         ->sum('amount');

    //     $pendapatanTahunIni = Order::where('status', 'Success')
    //         ->whereYear('created_at', now()->year)
    //         ->sum('amount');

    //     // Mengambil data pendapatan per bulan untuk tahun ini
    //     $pendapatanPerBulan = [];
    //     for ($month = 1; $month <= 12; $month++) {
    //         $pendapatanPerBulan[Carbon::create()->month($month)->format('M')] = Order::where('status', 'Success')
    //             ->whereMonth('created_at', $month)
    //             ->sum('amount');
    //     }

    //     // Jika bukan 'Customer', tampilkan halaman dashboard
    //     return view('dashboard.index', compact([
    //         'pesananDiterima',
    //         'pesananSuccess',
    //         'totalPendapatanHariIni',
    //         'pendapatanBulanIni',
    //         'pendapatanTahunIni',
    //         'pendapatanPerBulan'
    //     ]));
    // }

    public function index()
    {
        $user = auth()->user();

        // Redirect jika belum verifikasi email
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // Jika user adalah customer, redirect ke homepage
        if ($user->hasRole('Customer')) {
            return redirect('/');
        }

        // Bukan customer dan email sudah terverifikasi → tampilkan dashboard
        $pesananDiterima = Order::where('status', 'Pending')->count();
        $pesananSuccess = Order::where('status', 'Success')->count();

        $totalPendapatanHariIni = Order::where('status', 'Success')
            ->whereDate('created_at', now())
            ->sum('amount');

        $pendapatanBulanIni = Order::where('status', 'Success')
            ->whereMonth('created_at', now()->month)
            ->sum('amount');

        $pendapatanTahunIni = Order::where('status', 'Success')
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $pendapatanPerBulan = [];
        for ($month = 1; $month <= 12; $month++) {
            $pendapatanPerBulan[\Carbon\Carbon::create()->month($month)->format('M')] =
                Order::where('status', 'Success')
                ->whereMonth('created_at', $month)
                ->sum('amount');
        }

        // Produk yang sering dipesan
        $produkTerlaris = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->select('products.name', DB::raw('SUM(order_details.quantity) as total_dipesan'))
            ->where('orders.status', 'Success')
            ->groupBy('order_details.product_id', 'products.name')
            ->orderByDesc('total_dipesan')
            ->limit(10)
            ->get();

        // dd($produkTerlaris);
        return view('dashboard.index', compact(
            'pesananDiterima',
            'pesananSuccess',
            'totalPendapatanHariIni',
            'pendapatanBulanIni',
            'pendapatanTahunIni',
            'pendapatanPerBulan',
            'produkTerlaris'
        ));
    }
}
