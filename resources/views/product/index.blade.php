@extends('layouts.app')

@section('title', 'Data Produk')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Data Produk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-12 col-md-12">
            <x-card>
                @can('Category Store')
                    <x-slot name="header">
                        <button onclick="addForm(`{{ route('products.store') }}`)" class="btn btn-sm btn-primary"><i
                                class="fas fa-plus-circle"></i> Tambah
                            Data</button>
                    </x-slot>
                @endcan
                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>ori_kw</th>
                        <th>tanggal</th>
                        <th>catatan</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @include('product.form')
@endsection

@include('includes.datatable')
@include('includes.select2')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let button = '#submitBtn';

        $(function() {
            $('#spinner-border').hide();
        });

        $('.category_id').select2({
            closeOnSelect: true,
            allowClear: true,
            ajax: {
                url: '{{ route('category.search') }}',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name
                            };
                        })
                    };
                }
            }
        });


        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('products.data') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'path_image'
                },
                {
                    data: 'name'
                },
                {
                    data: 'category.name'
                },
                {
                    data: 'ori_kw'

                },
                {
                     data: 'product_date'

                },
                {
                     data: 'product_note'
                },
                {
                    data: 'price'
                },
                {
                    data: 'stock'

                },
                {
                    data: 'description'

                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // fungsi tambah data baru
        function addForm(url, title = 'Tambah Data Produk') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');
            // Hide the filename display
            resetForm(`${modal} form`);
        }

        // fungsi edit data
        function editForm(url, title = 'Edit Data Produk') {
            $.get(url) // Perform a GET request to the specified URL
                .done(response => {
                    $(modal).modal('show'); // Show the modal
                    $(`${modal} .modal-title`).text(title); // Set the modal title
                    $(`${modal} form`).attr('action', url); // Set the form action to the URL
                    $(`${modal} [name=_method]`).val('PUT'); // Set the HTTP method to PUT

                    resetForm(`${modal} form`); // Reset the form fields
                    loopForm(response.data);

                    // Membuat option baru dengan data kategori
                    var option = new Option(response.data.category.name, response.data.category.id, true, true);
                    $('#category_id').append(option).trigger(
                        'change'); // Menambahkan option ke select2 dan memicu perubahan
                })
                .fail(errors => { // Handle any errors from the GET request
                    $('#spinner-border').hide(); // Hide the spinner
                    $(button).prop('disabled', false); // Enable the button
                    Swal.fire({ // Show an error message
                        icon: 'error',
                        title: 'Oops! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide();
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors); // Handle validation errors
                    }
                });
        }

        // fungsi delete data
        function deleteData(url, name) {
            Swal.fire({
                title: 'Hapus Data!',
                text: 'Apakah Anda yakin ingin menghapus ' + name + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false,
                            });
                            table.ajax.reload(); // Refresh tabel
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: xhr.responseJSON?.message || 'Terjadi kesalahan.',
                            });
                        }
                    });
                }
            });
        }

        // fungsi kirim data inputan
        function submitForm(originalForm) {
            const submitBtn = $('#submitBtn'); // Reference to the button
            $(button).prop('disabled', true);
            $('#spinner-border').show();
            submitBtn.addClass('btn-progress');

            $.post({
                    url: $(originalForm).attr('action'),
                    data: new FormData(originalForm),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    $(modal).modal('hide');
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            $(button).prop('disabled', false);
                            $('#spinner-border').hide();
                            submitBtn.removeClass('btn-progress');
                            table.ajax.reload();
                        })
                    }
                })
                .fail(errors => {
                    $('#spinner-border').hide();
                    submitBtn.removeClass('btn-progress');
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide()
                        submitBtn.removeClass('btn-progress')
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
        }
    </script>
@endpush
