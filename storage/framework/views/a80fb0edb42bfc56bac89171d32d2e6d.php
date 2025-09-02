<?php if (isset($component)) { $__componentOriginale6a555649da86b3de44465cdfe004aa4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale6a555649da86b3de44465cdfe004aa4 = $attributes; } ?>
<?php $component = App\View\Components\Modal::resolve(['size' => 'modal-lg'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-backdrop' => 'static','data-keyboard' => 'false']); ?>
     <?php $__env->slot('title', null, []); ?> 
        Tambah
     <?php $__env->endSlot(); ?>

    <?php echo method_field('POST'); ?>

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="">Nama Role</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama role"
                    autocomplete="off">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <p>SELECT PERMISSIONS</p>
        </div>
    </div>
    

    

    <div class="row">
        <div class="col-md-12">
            <table class="table" style="width: 100%">
                <thead class="thead-light">
                    <tr>
                        <th>Nama</th>
                        <th>Action</th>
                        <th colspan="8"></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Baris Konfigurasi -->
                    <tr>
                        <td>Konfigurasi</td>
                        <td>Read</td>
                    </tr>
                    <!-- Sub-baris Menu -->
                    <?php $__currentLoopData = $permissionGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permissionGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($permissionGroup->name); ?></td>
                            <?php $__currentLoopData = $permissionGroup->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input"
                                                id="customSwitch_<?php echo e($permission->id); ?>">
                                            <label class="custom-control-label"
                                                for="customSwitch_<?php echo e($permission->id); ?>">Read</label>
                                        </div>
                                    </div>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <td colspan="5"></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>



     <?php $__env->slot('footer', null, []); ?> 
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-info" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale6a555649da86b3de44465cdfe004aa4)): ?>
<?php $attributes = $__attributesOriginale6a555649da86b3de44465cdfe004aa4; ?>
<?php unset($__attributesOriginale6a555649da86b3de44465cdfe004aa4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale6a555649da86b3de44465cdfe004aa4)): ?>
<?php $component = $__componentOriginale6a555649da86b3de44465cdfe004aa4; ?>
<?php unset($__componentOriginale6a555649da86b3de44465cdfe004aa4); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\konfigurasi\role\form2.blade.php ENDPATH**/ ?>