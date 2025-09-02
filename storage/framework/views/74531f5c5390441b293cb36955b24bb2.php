<?php $__env->startSection('content'); ?>
    <div class="container" style="margin-top: 20px;">
        <div class="alert alert-info">
            <h4 class="mb-3">Verifikasi Email Diperlukan</h4>
            <p>
                Sebelum melanjutkan, silakan periksa email Anda dan klik link verifikasi yang telah dikirim.
                Jika Anda tidak menerima email, klik tombol di bawah ini untuk mengirim ulang.
            </p>

            <?php if(session('message')): ?>
                <div class="alert alert-success mt-3">
                    <?php echo e(session('message')); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('verification.send')); ?>" class="mt-4">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-primary">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\auth\verify-email.blade.php ENDPATH**/ ?>