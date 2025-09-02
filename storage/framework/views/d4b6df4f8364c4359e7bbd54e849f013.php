<h2 class="text-xl font-bold mb-4">Tracking Info</h2>
<p><strong>Nomor Resi:</strong> <?php echo e($summary['waybill'] ?? '-'); ?></p>
<p><strong>Kurir:</strong> <?php echo e(strtoupper($summary['courier_name']) ?? '-'); ?></p>
<p><strong>Asal:</strong> <?php echo e($summary['origin'] ?? '-'); ?></p>
<p><strong>Tujuan:</strong> <?php echo e($summary['destination'] ?? '-'); ?></p>
<p><strong>Status:</strong> <?php echo e($summary['status'] ?? '-'); ?></p>

<hr class="my-4">

<h3 class="text-lg font-semibold">Riwayat Perjalanan:</h3>
<table class="table-auto w-full border mt-2">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 border">Tanggal & Waktu</th>
            <th class="px-4 py-2 border">Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = json_decode($order->manifest, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <?php echo e($item['manifest_date']); ?> <?php echo e($item['manifest_time']); ?> -
                <?php echo e($item['manifest_description']); ?>

            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>
</table>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\tracking\result.blade.php ENDPATH**/ ?>