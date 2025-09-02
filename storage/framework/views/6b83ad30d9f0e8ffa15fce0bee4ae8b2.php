<?php $__env->startSection('content'); ?>
    

    <div class="section">
        <div class="container">
            <div class="row">
                <!-- Judul Halaman -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Review Produk Terbaru</h3>
                    </div>
                </div>

                <!-- List Review -->
                
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <p class="card-text">
                                    <strong>Rating:</strong> ⭐/ 5<br>
                                    <strong>Review:</strong>
                                </p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Oleh: </small>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-12">
                        <p class="text-center">Belum ada review yang tersedia.</p>
                    </div>
                
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\frontend\review.blade.php ENDPATH**/ ?>