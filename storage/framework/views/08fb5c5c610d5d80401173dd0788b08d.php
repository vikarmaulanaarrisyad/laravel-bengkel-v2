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
        Tambah Data
     <?php $__env->endSlot(); ?>

    <?php echo method_field('POST'); ?>

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="name">Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama"
                    autocomplete="off">
            </div>
        </div>

        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="description">Deskripsi <span class="text-danger">*</span></label>
                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Masukkan deskripsi"></textarea>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="price">Harga <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="price" id="price" placeholder="Masukkan harga"
                    min="0" onkeyup="format_uang(this)">
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="stock">Stok <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="stock" id="stock" placeholder="Masukkan stok"
                    value="0" min="0">
            </div>
        </div>

        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="category_id">Kategori <span class="text-danger">*</span></label>
                <select class="form-control category_id select2" name="category_id" id="category_id">
                    <option value="">-- Pilih Kategori --</option>
                    <!-- Tambahkan kategori dari database -->
                </select>
            </div>
        </div>

        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="path_image">Gambar <span class="text-danger">*</span></label>
                <input type="file" class="form-control" name="path_image" id="path_image">
            </div>
        </div>
    </div>
       
     <?php $__env->slot('footer', null, []); ?> 
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-info" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan
        </button>
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
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\product\form.blade.php ENDPATH**/ ?>