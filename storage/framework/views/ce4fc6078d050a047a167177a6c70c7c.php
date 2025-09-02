<?php $__env->startSection('title', 'Laporan Penjualan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
	<h1 class="mb-4">Laporan Penjualan</h1>
	<div class="card">
		<div class="card-body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Nama Pembeli</th>
						<th>Produk</th>
						<th>Qty</th>
						<th>Total</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php $__empty_1 = true; $__currentLoopData = $penjualan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
						<?php $__currentLoopData = $order->orderDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($loop->parent->iteration); ?>.<?php echo e($loop->iteration); ?></td>
							<td><?php echo e($order->created_at->format('d-m-Y H:i')); ?></td>
							<td><?php echo e($order->user->name ?? '-'); ?></td>
							<td><?php echo e($detail->product->name ?? '-'); ?></td>
							<td><?php echo e($detail->qty); ?></td>
							<td>Rp<?php echo e(number_format($detail->qty * $detail->product->price, 0, ',', '.')); ?></td>
							<td><span class="badge badge-<?php echo e($order->statusColor()); ?>"><?php echo e($order->status); ?></span></td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
						<tr>
							<td colspan="7" class="text-center">Tidak ada data penjualan</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\laporanpenjualan\index.blade.php ENDPATH**/ ?>