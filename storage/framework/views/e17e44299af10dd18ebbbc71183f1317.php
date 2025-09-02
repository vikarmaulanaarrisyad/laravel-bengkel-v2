<?php $__env->startSection('content'); ?>
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
            <form id="checkout-form">
                <div class="row">
                    <div class="col-md-7">
                        <!-- Billing Details -->
                        <div class="billing-details">
                            <div class="section-title">
                                <h3 class="title">Alamat Pengiriman</h3>
                            </div>

                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input class="input form-control" type="text" name="name" id="name" placeholder="Nama Lengkap" required>
                            </div>

                            <!-- Provinsi -->
                            <div class="form-group">
                                <label for="provinces">Provinsi</label>
                                <select name="province_id" id="provinces" class="form-control" required>
                                    <option disabled selected value="">Pilih Provinsi</option>
                                </select>
                            </div>

                            <!-- Kabupaten -->
                            <div class="form-group">
                                <label for="regencies">Kabupaten / Kota</label>
                                <select name="regency_id" id="regencies" class="form-control" required>
                                    <option disabled selected value="">Pilih Kabupaten/Kota</option>
                                </select>
                            </div>

                            <!-- Kecamatan -->
                            <div class="form-group">
                                <label for="districts">Kecamatan</label>
                                <select name="district_id" id="districts" class="form-control" required>
                                    <option disabled selected value="">Pilih Kecamatan</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="address">Alamat Lengkap</label>
                                <textarea name="address" id="address" class="input form-control" cols="30" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, dll." required></textarea>
                            </div>

                            <!-- Berat dan Kurir -->
                            <div class="form-group">
                                <label for="weight">Berat (gram)</label>
                                <input type="number" name="weight" id="weight" class="form-control" value="1000" min="1" required>
                            </div>

                            <!-- Pilih Kurir -->
                            <div class="form-group">
                                <label for="courier">Kurir</label>
                                <select id="courier" name="courier" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Kurir --</option>
                                    <option value="jne">JNE</option>
                                    <option value="pos">POS</option>
                                    <option value="tiki">TIKI</option>
                                </select>
                            </div>

                            <!-- Pilih Layanan -->
                            <div class="form-group">
                                <label for="service">Layanan</label>
                                <select id="service" name="service" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Layanan --</option>
                                </select>
                            </div>

                            <!-- Origin toko (contoh: Tegal) -->
                            <input type="hidden" id="origin_id" name="origin_id" value="6097">
                        </div>
                        <!-- /Billing Details -->

                        <!-- Catatan -->
                        <div class="order-notes">
                             <div class="section-title">
                                <h3 class="title">Catatan (Opsional)</h3>
                            </div>
                            <textarea name="notes" class="input form-control" cols="30" rows="5" placeholder="Catatan untuk pesanan Anda"></textarea>
                        </div>
                        <!-- /Catatan -->
                    </div>

                    <div class="col-md-5 order-details">
                        <div class="section-title text-center">
                            <h3 class="title">Ringkasan Pesanan</h3>
                        </div>
                        <div class="order-summary">
                            <div class="order-col">
                                <div><strong>PRODUK</strong></div>
                                <div><strong>SUBTOTAL</strong></div>
                            </div>
                            <div class="order-products">
                                <?php $__currentLoopData = Cart::content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="order-col">
                                    <div><?php echo e($cart->qty); ?>x <?php echo e($cart->name); ?></div>
                                    <div>Rp. <?php echo e(number_format($cart->subtotal, 0, ',', '.')); ?></div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <hr>
                            <div class="order-col">
                                <div>Subtotal</div>
                                <div><strong class="order-subtotal">Rp. <?php echo e(Cart::subtotal(0,',','.')); ?></strong></div>
                            </div>
                             <div class="order-col">
                                <div>Ongkos Kirim</div>
                                <div><strong id="shipping-cost">Rp. 0</strong></div>
                            </div>
                            <hr>
                            <div class="order-col">
                                <div><strong>TOTAL</strong></div>
                                <div><strong class="order-total" id="grand-total">Rp. <?php echo e(Cart::total(0,',','.')); ?></strong></div>
                            </div>
                        </div>

                        <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="0">
                        <input type="hidden" name="grand_total" id="grand_total_input" value="<?php echo e(Cart::total(0,'','')); ?>">

                        <button type="submit" class="primary-btn btn-block order-submit">Buat Pesanan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /SECTION -->
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script>
    // Helper function to format currency
    function formatRupiah(angka, prefix) {
        let number_string = angka.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $(document).ready(function() {
        // Load Provinces on page load
        $.ajax({
            url: '/api/rajaongkir/provinces',
            method: 'GET',
            success: function(response) {
                if (response.data && Array.isArray(response.data)) {
                    response.data.forEach(function(province) {
                        $('#provinces').append(`<option value="${province.id}">${province.name}</option>`);
                    });
                }
            }
        });

        // Provinsi -> Kota/Kabupaten
        $('#provinces').on('change', function() {
            let provinceId = $(this).val();
            $('#regencies').html('<option selected disabled value="">Loading...</option>');
            $('#districts').html('<option selected disabled value="">Pilih Kecamatan</option>');
            $('#service').html('<option selected disabled value="">-- Pilih Layanan --</option>');
            updateTotal();

            $.ajax({
                url: '/api/rajaongkir/cities',
                method: 'GET',
                data: { province_id: provinceId },
                success: function(response) {
                    $('#regencies').html('<option disabled selected value="">Pilih Kabupaten/Kota</option>');
                    if (response.data && response.data.data && Array.isArray(response.data.data.data)) {
                        response.data.data.data.forEach(function(city) {
                            $('#regencies').append(`<option value="${city.id}">${city.name}</option>`);
                        });
                    }
                }
            });
        });

        // Kota/Kabupaten -> Kecamatan
        $('#regencies').on('change', function() {
            let cityId = $(this).val();
            $('#districts').html('<option selected disabled value="">Loading...</option>');
            $('#service').html('<option selected disabled value="">-- Pilih Layanan --</option>');
            updateTotal();

            $.ajax({
                url: '/api/rajaongkir/subdistricts',
                method: 'GET',
                data: { city_id: cityId },
                success: function(response) {
                    $('#districts').html('<option disabled selected value="">Pilih Kecamatan</option>');
                    if (response.data && Array.isArray(response.data.data)) {
                        response.data.data.forEach(function(district) {
                            $('#districts').append(`<option value="${district.id}">${district.name}</option>`);
                        });
                    }
                }
            });
        });

        $('#districts, #courier').on('change', function() {
            $('#service').html('<option selected disabled value="">-- Pilih Layanan --</option>');
            updateTotal();

            let courier = $('#courier').val();
            let destination_id = $('#districts').val();

            if (!courier || !destination_id) {
                return;
            }

            $('#service').html('<option selected disabled>Mencari layanan...</option>');

            $.ajax({
                url: '<?php echo e(route("rajaongkir.cost")); ?>',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    origin_id: $('#origin_id').val(),
                    destination_id: destination_id,
                    weight: $('#weight').val(),
                    courier: courier
                },
                success: function (res) {
                    $('#service').empty().append('<option value="" selected disabled>-- Pilih Layanan --</option>');

                    // --- PERBAIKAN DI SINI ---
                    // Sesuaikan loop dengan struktur JSON yang baru (datar)
                    if (res.status === 'success' && Array.isArray(res.data) && res.data.length > 0) {
                        res.data.forEach(function (layanan) { // Langsung loop ke setiap objek layanan
                            let harga = layanan.cost;
                            let etd = layanan.etd;
                            let namaLayanan = layanan.service;
                            let kodeKurir = layanan.code.toUpperCase();
                            let text = `${kodeKurir} - ${namaLayanan} (${formatRupiah(harga, 'Rp. ')}) (ETD: ${etd})`;

                            $('#service').append(
                                `<option value="${namaLayanan}" data-harga="${harga}">${text}</option>`
                            );
                        });
                    } else {
                        $('#service').html('<option disabled selected>Tidak ada layanan tersedia</option>');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    $('#service').html('<option disabled selected>Gagal memuat layanan</option>');
                }
            });
        });

        $('#service').on('change', function() {
            let shippingCost = $('option:selected', this).data('harga') || 0;
            updateTotal(shippingCost);
        });

        function updateTotal(shippingCost = 0) {
            let subtotal = <?php echo e(Cart::subtotal(0, '', '')); ?>;
            let grandTotal = parseInt(subtotal) + parseInt(shippingCost);

            $('#shipping-cost').text(formatRupiah(shippingCost, 'Rp. '));
            $('#grand-total').text(formatRupiah(grandTotal, 'Rp. '));

            $('#shipping_cost_input').val(shippingCost);
            $('#grand_total_input').val(grandTotal);
        }

        $('#checkout-form').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $('.order-submit').text('MEMPROSES...').attr('disabled', true);

            $.ajax({
                url: '<?php echo e(route("front.checkout_store")); ?>',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if(response.snap_token) {
                         snap.pay(response.snap_token, {
                            onSuccess: function(result){ window.location.href = '/checkout/history'; },
                            onPending: function(result){ alert("wating your payment!"); console.log(result); },
                            onError: function(result){ alert("payment failed!"); console.log(result); },
                            onClose: function(){ alert('you closed the popup without finishing the payment'); }
                        });
                    } else {
                        Swal.fire('Sukses!', 'Pesanan berhasil dibuat.', 'success').then(() => {
                           window.location.href = '/checkout/history';
                        });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    $.each(errors, function(key, value) {
                        errorMessages += value[0] + '\n';
                    });

                    Swal.fire('Oops!', 'Terjadi kesalahan:\n' + errorMessages, 'error');
                    $('.order-submit').text('Buat Pesanan').attr('disabled', false);
                }
            });
        });

    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views/frontend/checkout.blade.php ENDPATH**/ ?>