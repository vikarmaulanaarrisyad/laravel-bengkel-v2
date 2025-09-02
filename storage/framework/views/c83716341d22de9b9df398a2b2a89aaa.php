<?php $__env->startPush('scripts'); ?>
    <?php if(session()->has('success')): ?>
        <script>
            Swal.fire({
                title: 'Sukses!',
                text: '<?php echo e(session('message')); ?>',
                icon: 'success',
                showConfirmButton: false,
                timer: 3000
            })
            setTimeout(() => {
                $('.toasts-top-right').remove();
            }, 3000);
        </script>
    <?php elseif(session()->has('error')): ?>
        <script>
            Swal.fire({
                title: 'Error!',
                text: '<?php echo e(session('message')); ?>',
                icon: 'error',
            })
            setTimeout(() => {
                $('.toasts-top-right').remove();
            }, 3000);
        </script>
    <?php endif; ?>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\components\toast.blade.php ENDPATH**/ ?>