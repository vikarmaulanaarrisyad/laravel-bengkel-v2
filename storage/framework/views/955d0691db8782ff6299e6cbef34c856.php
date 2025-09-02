

<?php $__env->startSection('title', 'Transaksi Offline'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="mb-4">Transaksi Offline</h1>
    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('stokoffline.transaksi')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="product_id">Pilih Produk</label>
                    <select name="product_id" id="product_id" class="form-control" required>
                        <option value="">-- Pilih Produk --</option>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?> (Stok: <?php echo e($product->stok_offline); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="qty">Jumlah Pembelian</label>
                    <input type="number" name="qty" id="qty" class="form-control" min="1" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan Transaksi</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\konfigurasi\Stokoffline\transaksi.blade.php ENDPATH**/ ?>