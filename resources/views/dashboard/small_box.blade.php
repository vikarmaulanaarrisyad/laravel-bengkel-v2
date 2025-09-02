@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Pesanan Masuk -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $pesananDiterima }}</h3>
                    <p>Pesanan Masuk</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">
                    View Details <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Pesanan Sukses -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $pesananSuccess }}</h3>
                    <p>Pesanan Sukses</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="#" class="small-box-footer">
                    View Details <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Pendapatan Hari Ini -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($totalPendapatanHariIni, 0, ',', '.') }}</h3>
                    <p>Total Pendapatan Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="#" class="small-box-footer">
                    View Details <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Total Pendapatan Bulan Ini -->
        <div class="col-lg-6 col-12 mb-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h3>
                    <p>Total Pendapatan Bulan Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="#" class="small-box-footer">
                    View Details <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Pendapatan Tahun Ini -->
        <div class="col-lg-6 col-12 mb-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($pendapatanTahunIni, 0, ',', '.') }}</h3>
                    <p>Total Pendapatan Tahun Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="#" class="small-box-footer">
                    View Details <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>


    <!-- Rekap Produk Terlaris -->
    <div class="row">
        <div class="col-lg-12 col-12 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Top 10 Produk Terlaris</h3>
                </div>
                <div class="card-body table-responsive">
                    @if ($produkTerlaris->count() > 0)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Total Dipesan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produkTerlaris as $index => $produk)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $produk->name }}</td>
                                        <td>{{ $produk->total_dipesan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center">Belum ada data produk terlaris.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Grafik Pendapatan -->
    <div class="row">
        <div class="col-lg-12 col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Grafik Pendapatan</h3>
                </div>
                <div class="card-body">
                    <canvas id="pendapatanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('pendapatanChart').getContext('2d');
        var pendapatanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Pendapatan Bulanan',
                    data: [
                        {{ $pendapatanPerBulan['Jan'] }},
                        {{ $pendapatanPerBulan['Feb'] }},
                        {{ $pendapatanPerBulan['Mar'] }},
                        {{ $pendapatanPerBulan['Apr'] }},
                        {{ $pendapatanPerBulan['May'] }},
                        {{ $pendapatanPerBulan['Jun'] }},
                        {{ $pendapatanPerBulan['Jul'] }},
                        {{ $pendapatanPerBulan['Aug'] }},
                        {{ $pendapatanPerBulan['Sep'] }},
                        {{ $pendapatanPerBulan['Oct'] }},
                        {{ $pendapatanPerBulan['Nov'] }},
                        {{ $pendapatanPerBulan['Dec'] }}
                    ],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
