<?php $__env->startPush('css_vendor'); ?>
    <link rel="stylesheet"
        href="<?php echo e(asset('/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts_vendor'); ?>
    <script src="<?php echo e(asset('/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $('.datepicker').datetimepicker({
            icons: {
                time: 'far fa-clock'
            },
            format: 'YYYY-MM-DD',
            locale: 'id'
        });

        $('.datetimepicker').datetimepicker({
            icons: {
                time: 'far fa-clock'
            },
            format: 'YYYY-MM-DD HH:mm',
            locale: 'id'
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\includes\datepicker.blade.php ENDPATH**/ ?>