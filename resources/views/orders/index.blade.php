@extends('layouts.app')

@section('title', 'Data Pembelian')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Data Pembelian</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-12 col-md-12">
            <x-card>
                <x-table class="pembelian">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Invoice</th>
                        <th>Resi</th>
                        <th>Tgl Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Transaksi</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @include('orders.detail')
    @include('orders.resi')
@endsection

@include('includes.datatable')
@include('includes.select2')

@push('scripts')
    <script>
        let table, table2;
        let modal = '#modal-form';
        let modalDetail = '.modal-detail';
        let button = '#submitBtn';

        $(function() {
            $('#spinner-border').hide();
        });

        function openResiModal(orderId) {
            $('#modal_order_id').val(orderId);
            $('#resiModal').modal('show');
        }

        table = $('.pembelian').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('orders.data') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'invoice_number'
                },
                {
                    data: 'awb'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'user.name'
                },
                {
                    data: 'peyment_type'
                },
                {
                    data: 'status'
                },
                {
                    data: 'amount'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        table2 = $('.pembelianDetail').DataTable({
            processing: true,
            bSort: false,
            dom: 'Brt',
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'product.name',
                },
                {
                    data: 'quantity',
                    searchable: false,
                    sortable: false,
                    class: 'text-center'
                },
                {
                    data: 'price',
                    searchable: false,
                    sortable: false,
                    class: 'text-right'
                },

                {
                    data: 'subtotal',
                    sortable: false,
                    searchable: false,
                    class: 'text-right'
                },
            ]
        });

        function showDetail(url, title = "Detail Pembelian") {
            $(modalDetail).modal('show');
            $(`${modalDetail} .modal-title`).text(title);

            table2.ajax.url(url);
            table2.ajax.reload();
        }
    </script>
@endpush
