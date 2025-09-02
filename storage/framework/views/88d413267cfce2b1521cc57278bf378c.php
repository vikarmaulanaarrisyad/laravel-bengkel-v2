<?php $__env->startSection('title', 'Profil'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('breadcrumb'); ?>
    <li class="breadcrumb-item active">Profil</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php if(request('pills') == ''): ?> active <?php endif; ?>"
                        href="<?php echo e(route('profile.show')); ?>">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(request('pills') == 'password'): ?> active <?php endif; ?>"
                        href="<?php echo e(route('profile.show')); ?>?pills=password">Password</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade <?php if(request('pills') == ''): ?> show active <?php endif; ?>" id="pills-profil"
                    role="tabpanel" aria-labelledby="pills-profil-tab">
                    <?php if ($__env->exists('profile.update-profile-information-form')) echo $__env->make('profile.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                <div class="tab-pane fade <?php if(request('pills') == 'password'): ?> show active <?php endif; ?>" id="pills-password"
                    role="tabpanel" aria-labelledby="pills-password-tab">
                    <?php if ($__env->exists('profile.update-password-form')) echo $__env->make('profile.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\profile\show.blade.php ENDPATH**/ ?>