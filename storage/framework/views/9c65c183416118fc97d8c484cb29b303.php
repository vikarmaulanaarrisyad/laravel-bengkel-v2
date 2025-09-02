<?php $__env->startPush('css_vendor'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('/AdminLTE/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts_vendor'); ?>
    <script src="<?php echo e(asset('/AdminLTE/plugins/select2/js/select2.full.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: '<?php echo e(isset($placeholder) ? $placeholder : 'Pilih salah satu'); ?>',
            closeOnSelect: true,
            allowClear: true,
        });

        $('.select2-search__field').css('width', '100%');
        $('.select2-container--bootstrap4 .select2-selection--multiple .select2-search__field')
            .css('margin-left', '.3rem')
            .css('margin-top', '.35rem');
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\includes\select2.blade.php ENDPATH**/ ?>