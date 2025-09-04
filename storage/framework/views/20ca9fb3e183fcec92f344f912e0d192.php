<?php $__env->startSection('content'); ?>
    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">Order History</h3>
                    <ul class="breadcrumb-tree">
                        <li><a href="#">Home</a></li>
                        <li class="active">Order History</li>
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
                <div class="col-md-12">
                    <h4>Your Order History</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Status Pembayaran</th>
                                <th>Status Pesanan</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($order->invoice_number); ?></td>
                                    <td><?php echo e($order->created_at->format('Y-m-d H:i:s')); ?></td>
                                    <td>Rp <?php echo e(number_format($order->amount, 0, ',', '.')); ?></td>
                                    <td><?php echo e(ucfirst($order->status)); ?></td>
                                    <td><?php echo e(ucfirst(optional($order)->status_summary ?? 'Sedang diproses')); ?></td>
                                    <td>

                                        <?php if($order->status == 'Success'): ?>
                                            <a href="<?php echo e(route('orders.download', $order->id)); ?>" class="btn btn-primary">
                                                Download Invoice
                                            </a>
                                            <button onclick="showModalHistory('<?php echo e(route('order.details', $order->id)); ?>')"
                                                class="btn btn-info">
                                                View Details
                                            </button>
                                        <?php endif; ?>
                                        <?php if($order->status == 'Pending'): ?>
                                            <button class="btn btn-success pay-button" data-id="<?php echo e($order->id); ?>">Bayar
                                                Sekarang</button>
                                        <?php endif; ?>
                                        
                                        <?php if($order->status_summary != null): ?>
                                            <button class="btn btn-primary"
                                                onclick="showTrackingModal('<?php echo e($order->awb); ?>', '<?php echo e($order->courier); ?>')">
                                                Lacak Resi
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /SECTION -->

    <?php echo $__env->make('frontend.modalhistory', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('frontend.resifront', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <form action="<?php echo e(route('payment.paymentSuccess')); ?>" method="post" id="submitForm">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="json" id="js_callback">
        <input type="hidden" name="id_order" id="id_order" value="">
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?php echo e(config('midtrans.client_key')); ?>"></script>

    <script>
        function showModalHistory(url) {
            let modal = '#orderDetailsModal';
            $(modal).modal('show');

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    const order = response.order;

                    $(modal + ' .modal-title').text('Order Details: ' + order.invoice_number);
                    $(modal + ' #modal-invoice').text(order.invoice_number);
                    $(modal + ' #modal-date').text(formatDate(order.created_at));
                    $(modal + ' #modal-amount').text('Rp ' + order.amount.toLocaleString('id-ID'));
                    $(modal + ' #modal-status').text(order.status);
                    $(modal + ' #modal-status-summary').text(order.status_summary ?? 'Sedang Diproses');

                    let itemsHtml = '';
                    if (order.order_detail && Array.isArray(order.order_detail)) {
                        order.order_detail.forEach(function(item) {
                            const productName = item.product ? item.product.name : 'No Product';
                            itemsHtml += `
                                <tr>
                                    <td>${productName}</td>
                                    <td>Rp ${item.price.toLocaleString('id-ID')}</td>
                                    <td>${item.quantity}</td>
                                    <td>Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</td>
                                </tr>
                            `;
                        });

                        // TAMBAHKAN FORM REVIEW
                        let reviewHtml = '<h5 class="mt-4">Ulas Produk</h5>';
                        order.order_detail.forEach(function(item) {
                            const productName = item.product ? item.product.name :
                                'Produk Tidak Dikenal';
                            const productId = item.product ? item.product.id : 0;
                            const orderId = order.id;

                            reviewHtml += `
                                <form action="/reviews" method="POST" class="mb-4">
                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                    <input type="hidden" name="product_id" value="${productId}">
                                    <input type="hidden" name="order_id" value="${orderId}">
                                    <div class="form-group">
                                        <label>Produk: <strong>${productName}</strong></label><br>
                                        <label>Rating:</label><br>
                                        <div>
                                            ${[1, 2, 3, 4, 5].map(r => `
                                                            <label class="mr-2">
                                                                <input type="radio" name="rating" value="${r}" required> ${r}⭐
                                                            </label>
                                                        `).join('')}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="comment">Komentar:</label>
                                        <textarea name="comment" class="form-control" rows="2" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm">Kirim Review</button>
                                </form>
                            `;
                        });
                        $(modal + ' #modal-reviews').html(reviewHtml);
                    } else {
                        itemsHtml = '<tr><td colspan="4" class="text-center">No items found.</td></tr>';
                        $(modal + ' #modal-reviews').html('');
                    }
                    $(modal + ' #modal-items').html(itemsHtml);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching order details:', error);
                    $(modal + ' .modal-body').html(
                        '<div class="text-center text-danger">Error loading order details.</div>');
                }
            });
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');
            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const payButtons = document.querySelectorAll('.pay-button');
            payButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-id');
                    fetch('<?php echo e(route('get-snap-token')); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                id: orderId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.snapToken) {
                                window.snap.pay(data.snapToken, {
                                    onSuccess: function(result) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Payment Success!',
                                            text: 'Your payment has been successfully processed.',
                                            confirmButtonText: 'OK'
                                        });
                                        sendResponseToForm(result, orderId);
                                    },
                                    onPending: function(result) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Payment Pending!',
                                            text: 'Your payment is still pending. Please wait for confirmation.',
                                            confirmButtonText: 'OK'
                                        });
                                        sendResponseToForm(result, orderId);
                                    },
                                    onError: function(result) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Payment Failed!',
                                            text: 'An error occurred while processing your payment. Please try again.',
                                            confirmButtonText: 'OK'
                                        });
                                    },
                                    onClose: function() {
                                        Swal.fire({
                                            icon: 'info',
                                            title: 'Payment Popup Closed',
                                            text: 'The payment popup was closed without completing the payment.',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed to get Snap Token',
                                    text: 'Please try again later.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => console.error('Error fetching snap token:', error));
                });
            });
        });

        function sendResponseToForm(result, orderId) {
            document.getElementById('js_callback').value = JSON.stringify(result);
            document.getElementById('id_order').value = orderId;
            document.getElementById('submitForm').submit();
        }

        function showTrackingModal(awb, courier) {
            $('#trackingModal').modal('show');
            $('#trackingContent').html('<p>Memuat data tracking...</p>');

            $.ajax({
                url: '<?php echo e(route('tracking.ajax')); ?>',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    awb: awb,
                    courier: courier
                },
                success: function(response) {
                    if (response.success) {
                        let manifest = response.manifest;
                        if (manifest.length === 0) {
                            $('#trackingContent').html('<p>Tidak ada data manifest.</p>');
                            return;
                        }
                        let html = '<ul class="list-group">';
                        manifest.forEach(item => {
                            html += `<li class="list-group-item">
                                <strong>${item.manifest_date} ${item.manifest_time || ''}</strong><br>
                                ${item.manifest_description}
                            </li>`;
                        });
                        html += '</ul>';
                        $('#trackingContent').html(html);
                    } else {
                        $('#trackingContent').html('<p>Gagal memuat data tracking.</p>');
                    }
                },
                error: function() {
                    $('#trackingContent').html('<p>Terjadi kesalahan saat mengambil data.</p>');
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\WEB PROJEK\laravel-bengkel\resources\views/frontend/historyorder.blade.php ENDPATH**/ ?>