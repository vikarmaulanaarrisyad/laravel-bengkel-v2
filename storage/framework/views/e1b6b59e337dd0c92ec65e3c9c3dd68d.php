<?php $__env->startSection('title', 'Setting'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('breadcrumb'); ?>
    <li class="breadcrumb-item active">Setting</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php if(request('pills') == ''): ?> active <?php endif; ?>"
                        href="<?php echo e(route('setting.index')); ?>">Identitas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(request('pills') == 'logo'): ?> active <?php endif; ?>"
                        href="<?php echo e(route('setting.index')); ?>?pills=logo">Logo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(request('pills') == 'sosial-media'): ?> active <?php endif; ?>"
                        href="<?php echo e(route('setting.index')); ?>?pills=sosial-media">Sosial Media</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade <?php if(request('pills') == ''): ?> show active <?php endif; ?>" id="pills-general"
                    role="tabpanel" aria-labelledby="pills-general-tab">
                    <?php if ($__env->exists('setting.general')) echo $__env->make('setting.general', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                <div class="tab-pane fade <?php if(request('pills') == 'logo'): ?> show active <?php endif; ?>" id="pills-logo"
                    role="tabpanel" aria-labelledby="pills-logo-tab">
                    <?php if ($__env->exists('setting.logo')) echo $__env->make('setting.logo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                <div class="tab-pane fade <?php if(request('pills') == 'sosial-media'): ?> show active <?php endif; ?>" id="pills-sosial-media"
                    role="tabpanel" aria-labelledby="pills-sosial-media-tab">
                    <?php if ($__env->exists('setting.sosial_media')) echo $__env->make('setting.sosial_media', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php if ($__env->exists('includes.summernote')) echo $__env->make('includes.summernote', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php if (isset($component)) { $__componentOriginal49115d54aa597d93edb47e0b269dd843 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49115d54aa597d93edb47e0b269dd843 = $attributes; } ?>
<?php $component = App\View\Components\Toast::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Toast::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49115d54aa597d93edb47e0b269dd843)): ?>
<?php $attributes = $__attributesOriginal49115d54aa597d93edb47e0b269dd843; ?>
<?php unset($__attributesOriginal49115d54aa597d93edb47e0b269dd843); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49115d54aa597d93edb47e0b269dd843)): ?>
<?php $component = $__componentOriginal49115d54aa597d93edb47e0b269dd843; ?>
<?php unset($__componentOriginal49115d54aa597d93edb47e0b269dd843); ?>
<?php endif; ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\setting\index.blade.php ENDPATH**/ ?>