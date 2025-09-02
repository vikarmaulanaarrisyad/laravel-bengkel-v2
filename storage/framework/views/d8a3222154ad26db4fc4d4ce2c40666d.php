<?php $__env->startPush('css_vendor'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('/AdminLTE/plugins/summernote/summernote-bs4.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts_vendor'); ?>
    <script src="<?php echo e(asset('/AdminLTE/plugins/summernote/summernote-bs4.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $('.summernote').summernote({
            fontNames: [''],
            height: 200
        });

        $('.note-btn-group.note-fontname').remove();
        setTimeout(() => {
            $('.note-btn-group.note-fontname').remove();
        }, 300);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\includes\summernote.blade.php ENDPATH**/ ?>