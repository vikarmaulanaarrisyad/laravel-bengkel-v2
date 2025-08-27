@extends('layouts.front')

@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">Checkout</h3>
                    <ul class="breadcrumb-tree">
                        <li><a href="#">Home</a></li>
                        <li class="active">Checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <div class="container">
            <div class="row">

                <div class="col-md-7">
                    <!-- Billing Details -->
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">Alamat Pengiriman</h3>
                        </div>
                        <div class="form-group">
                            <input class="input form-control" type="text" name="name" id="name"
                                placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <input class="input form-control" type="text" name="address" id="address"
                                placeholder="Alamat Lengkap">
                        </div>
                        <div class="form-group">
                            <input class="input form-control" type="tel" name="phone" id="phone"
                                placeholder="Nomor Hp">
                        </div>
                    </div>
                    <!-- /Billing Details -->

                    <!-- Shipping Details -->
                    <div class="shipping-details">
                        <div class="section-title">
                            <h3 class="title">Catatan</h3>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="order-notes">
                        <textarea class="input form-control" placeholder="Catatan"></textarea>
                    </div>
                    <!-- /Order Notes -->
                </div>

                <div class="col-md-5">
                    <!-- Cart Items -->
                    <div id="cartContent" class="cart-content">
                        @foreach (Cart::content() as $cartItem)
                            <div class="cart-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h4>{{ $cartItem->name }}</h4>
                                    <p>Price: Rp. {{ $cartItem->price }}</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="number" value="{{ $cartItem->qty }}" min="1"
                                        id="qty-{{ $cartItem->rowId }}">
                                    <button class="btn btn-primary"
                                        onclick="cartIncrement('{{ $cartItem->rowId }}')">+</button>
                                    <button class="btn btn-danger"
                                        onclick="cartDecrement('{{ $cartItem->rowId }}')">-</button>
                                </div>
                            </div>
                        @endforeach
                        <p><strong>Total: Rp. {{ Cart::total() }}</strong></p>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>PRODUCT</th>
                                    <th>QTY</th>
                                    <th>PRICE</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                    <tr>
                                        <td>{{ $cart->name }}</td>
                                        <td>{{ $cart->qty }}</td>
                                        <td>Rp. {{ format_uang($cart->price) }}</td>
                                        <td>Rp. {{ format_uang($cart->price * $cart->qty) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"><strong>TOTAL</strong></td>
                                    <td><strong class="order-total">Rp.
                                            {{ format_uang($cart->price * $cart->qty) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <button class="primary-btn order-submit" onclick="checkout()">Place order</button>

            </div>
        </div>
    </div>
    <!-- /SECTION -->
@endsection

@push('scripts')
    <script>
        function checkout() {
            const name = $('#name').val();
            const address = $('#address').val();
            const phone = $('#phone').val();
            const orderNotes = $('.order-notes textarea').val();

            if (!name || !address || !phone) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Semua field wajib diisi!',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const data = {
                name: name,
                address: address,
                phone: phone,
                order_notes: orderNotes,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: '{{ route('front.checkout_store') }}',
                method: 'POST',
                data: data,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = response.redirect;
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    const errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                        'Terjadi kesalahan saat memproses pesanan.';
                    Swal.fire({
                        title: 'Gagal!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    </script>
@endpush

@push('css')
    <style>
        /* General Styles */
        .section {
            padding: 60px 0;
        }

        .breadcrumb-tree {
            padding: 0;
            list-style: none;
            display: flex;
            gap: 10px;
        }

        .breadcrumb-tree li {
            font-size: 14px;
        }

        .order-summary th,
        .order-summary td {
            text-align: center;
            vertical-align: middle;
        }

        /* Table Styling */
        .order-summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-summary th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .order-summary .order-total {
            font-weight: bold;
        }

        /* Form Elements */
        .input.form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }

        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            margin-bottom: 10px;
        }

        .cart-item h4 {
            margin: 0;
        }

        .cart-item input {
            width: 50px;
            text-align: center;
        }

        .cart-item button {
            margin-left: 5px;
        }

        @media (max-width: 767px) {
            .section-title h3 {
                font-size: 18px;
            }

            .cart-item {
                display: block;
                text-align: center;
            }

            .cart-item input {
                margin: 10px 0;
            }
        }
    </style>
@endpush
