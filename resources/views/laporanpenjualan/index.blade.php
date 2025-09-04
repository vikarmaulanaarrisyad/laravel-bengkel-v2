@extends('layouts.app')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Data Penjualan</li>
@endsection

@section('title', 'Laporan Penjualan')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-12 col-md-12">
            <x-card>
                <x-table class="pembelian">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Pembeli</th>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Status</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
@endsection

@include('includes.datatable')
@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let button = '#submitBtn';

        $(function() {
            $('#spinner-border').hide();
        });

        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('laporanpenjualan.data') }}'
            },
            pageLength: 30, // default tampil 30 data
            lengthChange: false, // hilangkan dropdown "Show entries"
            searching: false, // hilangkan search box
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'user'
                },
                {
                    data: 'products'
                },
                {
                    data: 'quantity'
                },
                {
                    data: 'subtotal'
                },
                {
                    data: 'status'
                },
            ]
        });
    </script>
@endpush
