<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Generate Nomor Resi Palsu & Simulasi Tracking</h1>

        <p>Order ID: <?php echo e($order->id); ?></p>
        <p>Current AWB: <?php echo e($order->awb ?? '-'); ?></p>
        <p>Current Courier: <?php echo e(ucfirst($order->courier) ?? '-'); ?></p>

        <?php if(session('success')): ?>
            <div style="color: green; margin-bottom: 1rem;">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div style="color: red; margin-bottom: 1rem;">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('orders.fake-resi.create')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">

            <label for="courier">Pilih Kurir:</label>
            <select name="courier" id="courier" required>
                <option value="">-- Pilih Kurir --</option>
                <option value="jne">JNE</option>
                <option value="jnt">JNT</option>
                <option value="tiki">TIKI</option>
                <option value="sicepat">SiCepat</option>
                <option value="anteraja">Anteraja</option>
                <option value="wahana">Wahana</option>
            </select>

            <br><br>
            <button type="submit">Generate Nomor Resi Palsu & Simulasi Tracking</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\orders\fake_resi_form.blade.php ENDPATH**/ ?>