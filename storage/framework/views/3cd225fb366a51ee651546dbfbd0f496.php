<?php $__env->startSection('title', 'Edit Stok Offline'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="mb-4">Edit Stok Offline</h1>
    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('stokoffline.update', $product->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" class="form-control" value="<?php echo e($product->name); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" class="form-control" value="<?php echo e($product->category->name ?? '-'); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Stok Offline</label>
                    <input type="number" name="stok_offline" class="form-control" value="<?php echo e($product->stok_offline ?? 0); ?>" min="0" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="<?php echo e(route('stokoffline.index')); ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\WEB PROJEK\laravel-bengkel\resources\views/konfigurasi/Stokoffline/edit.blade.php ENDPATH**/ ?>