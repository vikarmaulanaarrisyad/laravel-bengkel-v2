<?php $__env->startSection('title', 'Stok Offline'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
	<?php if(session('success')): ?>
		<div class="alert alert-success"><?php echo e(session('success')); ?></div>
	<?php endif; ?>
	<h1 class="mb-4">Stok Offline</h1>
	<div class="row mb-3">
		<div class="col-md-6">
			<div class="card card-info">
				<div class="card-body">
					<strong>Total Produk:</strong> <?php echo e($products->count()); ?><br>
					<strong>Total Stok Offline:</strong> <?php echo e($products->sum('stok_offline')); ?>

				</div>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Produk</th>
						<th>Kategori</th>
						<th>Stok Offline</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
						<tr>
							<td><?php echo e($loop->iteration); ?></td>
							<td><?php echo e($product->name); ?></td>
							<td><?php echo e($product->category->name ?? '-'); ?></td>
							<td><?php echo e($product->stok_offline ?? 0); ?></td>
							<td>
								<a href="<?php echo e(route('stokoffline.edit', $product->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
							</td>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
						<tr>
							<td colspan="4" class="text-center">Tidak ada data produk</td>
								<td></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\WEB PROJEK\laravel-bengkel\resources\views/konfigurasi/Stokoffline/index.blade.php ENDPATH**/ ?>