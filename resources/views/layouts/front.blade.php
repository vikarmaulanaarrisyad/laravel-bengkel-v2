<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    @php
        $setting = \App\Models\Setting::first();
    @endphp
    <title>{{ $setting->company_name }}</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/bootstrap.min.css" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/slick.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/slick-theme.css" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/nouislider.min.css" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/font-awesome.min.css">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/style.css" />

    @stack('css')

</head>

<body>
    <!-- HEADER -->
    <header>
        <!-- TOP HEADER -->
        @include('frontend.topheader')
        <!-- /TOP HEADER -->

        <!-- MAIN HEADER -->
        @include('frontend.mainheader')
        <!-- /MAIN HEADER -->
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    @include('frontend.nav')
    <!-- /NAVIGATION -->

    @yield('content')

    <!-- SECTION -->
    {{--  @include('frontend.newproduct')  --}}
    <!-- /SECTION -->

    <!-- NEWSLETTER -->
    <div id="newsletter" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="newsletter">
                        <p>Sign Up for the <strong>NEWSLETTER</strong></p>
                        <form>
                            <input class="input" type="email" placeholder="Enter Your Email">
                            <button class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
                        </form>
                        <ul class="newsletter-follow">
                            <li>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /NEWSLETTER -->

    <!-- FOOTER -->
    @include('frontend.footer')
    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    <script src="{{ asset('frontend') }}/js/jquery.min.js"></script>
    <script src="{{ asset('frontend') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('frontend') }}/js/slick.min.js"></script>
    <script src="{{ asset('frontend') }}/js/nouislider.min.js"></script>
    <script src="{{ asset('frontend') }}/js/jquery.zoom.min.js"></script>
    <script src="{{ asset('frontend') }}/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('scripts')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        // function add to cart
        function addToCart(id) {
            let product_name = $('#product_name').val()
            let qty = 1

            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    product_name: product_name,
                    qty: qty,
                },
                url: "/cart/data/store/" + id,
                success: function(data) {
                    miniCart()
                    //$('#closeModal').click()
                    Swal.fire({
                        title: "Berhasil",
                        text: data.success,
                        showConfirmButton: false,
                        timer: 3000,
                        icon: "success"
                    });
                }
            });
        }
    </script>

    <script>
        function miniCart() {
            $.ajax({
                type: "GET",
                url: '/product/mini/cart',
                dataType: 'json',
                success: function(response) {

                    $('#cartSubTotal').text('SUBTOTAL: ' + response.cartTotal)
                    $('#cartQty').text(response.cartQty)
                    $('#itemSelect').text(response.cartQty + " Item(s) selected")

                    let miniCart = ""

                    $.each(response.carts, function(key, value) {
                        miniCart += `
                            <div class="cart-list">
                                <div class="product-widget">
                                    <div class="product-img">
                                        <img src="${value.options.image}" alt="">
                                    </div>
                                    <div class="product-body">
                                        <h3 class="product-name"><a href="#">${value.name}</a></h3>
                                        <h4 class="product-price"><span class="qty">${value.qty}x</span>Rp. ${value.price}</h4>
                                    </div>
                                    <button class="delete" type="submit" onclick="miniCartRemove(this.id)" id="${value.rowId}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                    });



                    $('#miniCart').html(miniCart)
                }
            })
        }

        miniCart()

        // remove mini cart
        function miniCartRemove(rowId) {
            $.ajax({
                type: 'GET',
                url: "/minicart/product-remove/" + rowId,
                dataType: 'json',
                success: function(data) {
                    Swal.fire({
                        title: "Berhasil",
                        text: data.success,
                        showConfirmButton: false,
                        timer: 3000,
                        icon: "success"
                    }).then(() => {
                        miniCart()
                        cart()
                    });

                }
            })
        }
        // get MyCart
        function cart() {
            $.ajax({
                type: "GET",
                url: '/get-mycart-product',
                dataType: 'json',
                success: function(response) {
                    let row = ""

                    $.each(response.carts, function(key, value) {
                        row += `
                              <tr>
                                        <td class="col-md-2"><img src="${value.options.image}" alt="imga" style="width:60px; height: 60px;"></td>
                                        <td class="col-md-2">
                                            <div class="product-name"><a href="#">${value.name}</a></div>
                                        </td>

                                        <td class="col-md-2">
                                             <strong>
                                              ${formatRupiah(value.price)}
                                            </strong>
                                        </td>

                                        <td class="col-md-1">
                                            ${value.options.color == null ? `<strong>.....</strong>` : `<strong>${value.options.color}</strong>` }
                                        </td>

                                        <td class="col-md-1">
                                            ${value.options.size == 0 ? `<strong>.....</strong>` : `<strong>${value.options.size}</strong>` }
                                        </td>

                                        <td class="col-md-2">
                                             <button class="btn btn-sm btn-success" id="${value.rowId}" onclick="cartIncrement(this.id)" >+</button>
                                            <input type="text" value="${value.qty}" min="1" max="100" disabled style="width:30px; text-align:center">
                                            ${value.qty > 1 ?
                                            ` <button class="btn btn-sm btn-danger" id="${value.rowId}" onclick="cartDecrement(this.id)" >-</button>` :

                                            `<button class="btn btn-sm btn-danger" disabled>-</button>`

                                        }

                                        </td>
                                        <td class="col-md-2">
                                            <strong>${formatRupiah(value.subtotal)}</strong>
                                        </td>

                                        <td class="col-md-2 close-btn">
                                            <button type="submit" id="${value.rowId}" onclick="removeMyCart(this.id)" ><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>

                        `
                    })
                    $('#getMyCart').html(row)
                    $('#grandTotal').text(formatRupiah(response.cartTotal))
                }
            })
        }

        cart()

        function removeMyCart(id) {
            $.ajax({
                type: 'GET',
                url: "/remove-mycart/" + id,
                dataType: 'json',
                success: function(data) {
                    Swal.fire({
                        title: "Berhasil",
                        text: data.success,
                        showConfirmButton: false,
                        timer: 3000,
                        icon: "success"
                    }).then(() => {
                        cart()
                        miniCart()
                    });

                }
            })
        }

        // Cart Increment
        function cartIncrement(rowId) {
            $.ajax({
                type: "GET",
                url: "/cart-increment/" + rowId,
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.error,
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Jumlah barang diperbarui.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            cart();
                            miniCart();
                            window.location.reload()
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Tidak dapat mengupdate keranjang. Silakan coba lagi.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        // Cart Decrement
        function cartDecrement(rowId) {
            $.ajax({
                type: "GET",
                url: "/cart-decrement/" + rowId,
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.error,
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Jumlah barang dikurangi.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Update the cart content and mini cart
                            cart();
                            miniCart();
                            // Optionally, reload the page (if needed, though it's better to avoid reloading)
                            window.location.reload();
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Tidak dapat mengupdate keranjang. Silakan coba lagi.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        $(document).ready(function() {
            // Listen for changes on the quantity input field
            $('[id^="qty-"]').on('input', function() {
                var rowId = $(this).attr('id').split('-')[1]; // Extract rowId from the input field ID
                var newQuantity = $(this).val(); // Get the updated quantity

                // Check if the new quantity is valid
                if (newQuantity < 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Quantity',
                        text: 'Quantity cannot be less than 1.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Send the updated quantity to the server
                $.ajax({
                    type: "GET",
                    url: "/cart-update/" + rowId + "/" + newQuantity,
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Update Failed',
                                text: response.error,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Quantity Updated',
                                text: 'The cart has been updated successfully.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Update cart and mini cart after quantity change
                                cart();
                                miniCart();
                                window.location.reload();
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Unable to update the cart. Please try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });


        function formatRupiah(number) {
            return "Rp.  " + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>


</body>

</html>
