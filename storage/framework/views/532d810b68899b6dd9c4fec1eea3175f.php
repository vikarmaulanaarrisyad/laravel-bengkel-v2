<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Order</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            margin: 20px auto;
            padding: 20px;
            max-width: 800px;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }

        .header p {
            margin: 0;
            color: #555;
            font-size: 14px;
        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }

        th {
            background-color: #007bff;
            color: #ffffff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .summary {
            margin-top: 20px;
            text-align: right;
            font-size: 14px;
            color: #555;
        }

        .summary p {
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }

        .footer p {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Invoice Order</h1>
            <p>Terima kasih telah melakukan pemesanan!</p>
        </div>

        <!-- Customer Details -->
        <div class="details">
            <p><strong>Nomor Invoice:</strong> <?php echo e($orders->invoice_number); ?></p>
            <p><strong>Nama Customer:</strong> <?php echo e($orders->name); ?></p>
            <p><strong>Tanggal Order:</strong> <?php echo e(\Carbon\Carbon::parse($orders->created_at)->format('d-m-Y h:i:s')); ?>

            </p>
            <p><strong>Status:</strong> <?php echo e(ucfirst($orders->status)); ?></p>
        </div>

        <!-- Order Details Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan (Rp)</th>
                    <th>Total Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $orders->orderDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($detail->product->name); ?></td>
                        <td><?php echo e($detail->quantity); ?></td>
                        <td><?php echo e(number_format($detail->price, 0, ',', '.')); ?></td>
                        <td><?php echo e(number_format($detail->price * $detail->quantity, 0, ',', '.')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <!-- Order Summary -->
        <div class="summary">
            <p><strong>Total Harga:</strong> Rp <?php echo e(number_format($orders->amount, 0, ',', '.')); ?></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; <?php echo e(date('Y')); ?> CV. Perusahaan Anda. Semua Hak Dilindungi.</p>
        </div>
    </div>
</body>

</html>
<?php /**PATH D:\WEB PROJEK\laravel-bengkel\resources\views/pdf/order-report.blade.php ENDPATH**/ ?>