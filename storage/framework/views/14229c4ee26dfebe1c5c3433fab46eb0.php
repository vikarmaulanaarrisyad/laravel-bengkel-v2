<?php if (isset($component)) { $__componentOriginale6a555649da86b3de44465cdfe004aa4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale6a555649da86b3de44465cdfe004aa4 = $attributes; } ?>
<?php $component = App\View\Components\Modal::resolve(['size' => 'modal-md'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                <label for="name">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan kategori"
                    autocomplete="off">
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12">
    <div class="form-group">
        <label>Jenis Produk <span class="text-danger">*</span></label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ori_kw_seccond" id="ori" value="Ori">
            <label class="form-check-label" for="ori">Ori</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ori_kw_seccond" id="kw" value="KW">
            <label class="form-check-label" for="kw">KW</label>
        <div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ori_kw_seccond" id="kw" value="seccond">
            <label class="form-check-label" for="seccond">seccond</label>
        </div>
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
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\category\form.blade.php ENDPATH**/ ?>