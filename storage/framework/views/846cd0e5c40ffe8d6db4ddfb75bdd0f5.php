<!-- Modal for Order Details -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Invoice:</strong> <span id="modal-invoice"></span></p>
                <p><strong>Date:</strong> <span id="modal-date"></span></p>
                <p><strong>Total Amount:</strong> Rp <span id="modal-amount"></span></p>
                <p><strong>Status:</strong> <span id="modal-status"></span></p>
                <p><strong>Status Pesanan:</strong> <span id="modal-status-summary"></span></p>

                <h5>Order Items:</h5>
                <!-- Tabel untuk Order Items -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="modal-items">
                        <!-- Data item pesanan akan ditambahkan di sini -->
                    </tbody>
                </table>

                <!-- Form Review -->
                <div id="modal-reviews">
                    <!-- Form review akan dimasukkan via JavaScript -->
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views/frontend/modalhistory.blade.php ENDPATH**/ ?>