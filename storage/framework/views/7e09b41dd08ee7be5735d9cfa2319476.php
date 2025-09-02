<form action="<?php echo e(route('setting.update', $setting->id)); ?>?pills=logo" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('put'); ?>

    <?php if (isset($component)) { $__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64 = $attributes; } ?>
<?php $component = App\View\Components\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <strong class="d-block text-center">Favicon</strong>
                <div class="text-center">
                    <img src="<?php echo e(Storage::url($setting->path_image ?? '')); ?>" alt=""
                        class="img-thumbnail preview-path_image" width="200">
                </div>
                <div class="form-group mt-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="path_image" name="path_image"
                            onchange="preview('.preview-path_image', this.files[0])">
                        <label class="custom-file-label" for="path_image">Choose file</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-4">
                <strong class="d-block text-center">Header</strong>
                <div class="text-center">
                    <img src="<?php echo e(Storage::url($setting->path_image_header ?? '')); ?>" alt=""
                        class="img-thumbnail preview-path_image_header" width="200">
                </div>
                <div class="form-group mt-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="path_image_header" name="path_image_header"
                            onchange="preview('.preview-path_image_header', this.files[0])">
                        <label class="custom-file-label" for="path_image_header">Choose file</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <strong class="d-block text-center">Footer</strong>
                <div class="text-center">
                    <img src="<?php echo e(Storage::url($setting->path_image_footer ?? '')); ?>" alt=""
                        class="img-thumbnail preview-path_image_footer" width="200">
                </div>
                <div class="form-group mt-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="path_image_footer" name="path_image_footer"
                            onchange="preview('.preview-path_image_footer', this.files[0])">
                        <label class="custom-file-label" for="path_image_footer">Choose file</label>
                    </div>
                </div>
            </div>
        </div>
         <?php $__env->slot('footer', null, []); ?> 
            <button type="reset" class="btn btn-dark">Reset</button>
            <button class="btn btn-primary">Simpan</button>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64)): ?>
<?php $attributes = $__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64; ?>
<?php unset($__attributesOriginal740c66ff9bbfcb19a96a45ba2fa42d64); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64)): ?>
<?php $component = $__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64; ?>
<?php unset($__componentOriginal740c66ff9bbfcb19a96a45ba2fa42d64); ?>
<?php endif; ?>
</form>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\setting\logo.blade.php ENDPATH**/ ?>