<div class="table-responsive text-nowrap">
    <table id="table" <?php echo e($attributes->merge(['class' => 'table table-striped dt-responsive nowrap mt-1 hover'])); ?>

        cellspacing="0" width="100%">
        <?php if(isset($thead)): ?>
            <thead>
                <?php echo e($thead); ?>

            </thead>
        <?php endif; ?>

        <tbody>
            <?php echo e($slot); ?>

        </tbody>

        <?php if(isset($tfoot)): ?>
            <tfoot>
                <?php echo e($tfoot); ?>

            </tfoot>
        <?php endif; ?>
    </table>
</div>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\components\table.blade.php ENDPATH**/ ?>