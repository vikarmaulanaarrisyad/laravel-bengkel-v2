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
                                <th>Status</th>
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
                                    <td>
                                        <button onclick="showModalHistory('<?php echo e(route('order.details', $order->id)); ?>')"
                                            class="btn btn-info">
                                            View Details
                                        </button>
                                        <?php if($order->status == 'Pending'): ?>
                                            <button class="btn btn-success pay-button" data-id="<?php echo e($order->id); ?>">Bayar
                                                Sekarang</button>
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

    <form action="<?php echo e(route('payment.paymentSuccess')); ?>" method="post" id="submitForm">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="json" id="js_callback">
        <input type="hidden" name="id_order" id="id_order" value="">
    </form>

    <?php echo $__env->make('frontend.modalhistory', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?php echo e(config('midtrans.client_key')); ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener untuk semua tombol dengan kelas 'pay-button'
            const payButtons = document.querySelectorAll('.pay-button');

            payButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-id');

                    // AJAX request untuk mendapatkan snapToken
                    fetch(`<?php echo e(route('payment.getSnapToken')); ?>`, {
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
                                // Memunculkan popup Snap Midtrans
                                window.snap.pay(data.snapToken, {
                                    onSuccess: function(result) {
                                        alert('Payment Success!');
                                        sendResponseToForm(result, orderId);
                                    },
                                    onPending: function(result) {
                                        alert('Payment Pending!');
                                        sendResponseToForm(result, orderId);
                                    },
                                    onError: function(result) {
                                        alert('Payment Failed!');
                                        console.error(result);
                                    },
                                    onClose: function() {
                                        alert('Payment popup closed.');
                                    }
                                });
                            } else {
                                alert('Failed to retrieve Snap Token!');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching snap token:', error);
                            alert('An error occurred while processing the payment.');
                        });
                });
            });
        });

        function sendResponseToForm(result, orderId) {
            document.getElementById('js_callback').value = JSON.stringify(result);
            document.getElementById('id_order').value = orderId;
            document.getElementById('submitForm').submit();
        }

        // Function to show the modal and fetch order details
        function showModalHistory(url) {
            let modal = '#orderDetailsModal';

            // Show the modal
            $(modal).modal('show');

            // Make an AJAX request to fetch the order details
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    const order = response.order;

                    // Update modal content with order details
                    $(modal + ' .modal-title').text('Order Details: ' + order.invoice_number);
                    $(modal + ' #modal-invoice').text(order.invoice_number);
                    $(modal + ' #modal-date').text(formatDate(order.created_at));
                    $(modal + ' #modal-amount').text('Rp ' + order.amount.toLocaleString('id-ID'));
                    $(modal + ' #modal-status').text(order.status);
                    $(modal + ' #modal-name').text(order.name);
                    $(modal + ' #modal-address').text(order.address);
                    $(modal + ' #modal-phone').text(order.phone);
                    $(modal + ' #modal-note').text(order.note);

                    // Populate order items table
                    let itemsHtml = '';
                    order.order_detail.forEach(item => {
                        itemsHtml += `
                            <tr>
                                <td>${item.product_id}</td>
                                <td>Rp ${item.price.toLocaleString('id-ID')}</td>
                                <td>${item.quantity}</td>
                                <td>Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</td>
                            </tr>
                        `;
                    });
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
            const month = String(date.getMonth() + 1).padStart(2, '0'); // months are 0-based
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');

            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\frontend\historyorderdetail.blade.php ENDPATH**/ ?>