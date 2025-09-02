<div
    <?php echo e($attributes->merge([
        'class' => 'modal fade',
        'id' => 'modal-form',
        'aria-labelledby' => 'exampleModalLabel',
        'aria-hidden' => 'true',
    ])); ?>>
    <div class="modal-dialog <?php echo e(isset($size) ? $size : 'modal-lg'); ?>">
        <div class="modal-content">
            <form method="<?php echo e(isset($method) ? $method : 'post'); ?>">
                <?php if(isset($title)): ?>
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo e($title); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <div class="modal-body">
                    <?php echo e($slot); ?>

                </div>

                <?php if(isset($footer)): ?>
                    <div class="modal-footer">
                        <?php echo e($footer); ?>

                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\components\modal.blade.php ENDPATH**/ ?>