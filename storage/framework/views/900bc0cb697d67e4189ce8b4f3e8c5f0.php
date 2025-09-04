<?php $__env->startSection('content'); ?>
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">All Categories</a></li>
                    <?php if($product && $product->category && $product->category->name): ?>
                        <li><a href="#"><?php echo e($product->category->name); ?></a></li>
                    <?php else: ?>
                        <li><a href="#">Category Not Available</a></li>
                    <?php endif; ?>
                    <li class="active"><?php echo e($product->name ?? 'Product Not Available'); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-md-5">
                <div id="product-imgs">
                    <div class="product-preview">
                        <img src="<?php echo e(Storage::url($product->path_image)); ?>" alt="<?php echo e($product->name ?? 'Image'); ?>" class="img-responsive" style="max-width:100%;">
                    </div>
                </div>
            </div>
            <!-- /Product Images -->

            <!-- Product Details -->
            <div class="col-md-7">
                <div class="product-details">
                    <h2 class="product-name"><?php echo e($product->name ?? 'Product Not Available'); ?></h2>
                    <div>
                        <h3 class="product-price">Rp. <?php echo e(format_uang($product->price ?? 0)); ?></h3>
                        <span class="product-available">In Stock: <?php echo e($product->stock ?? 'N/A'); ?></span>
                    </div>
                    <p><?php echo e($product->description ?? 'No description available.'); ?></p>

                    <div class="add-to-cart">
                        <button onclick="addToCart(<?php echo e($product->id ?? 0); ?>)" class="add-to-cart-btn">
                            <i class="fa fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>

                    <ul class="product-links">
                        <li>Category:</li>
                        <?php if($product && $product->category && $product->category->name): ?>
                            <li><a href="#"><?php echo e($product->category->name); ?></a></li>
                        <?php else: ?>
                            <li><a href="#">No Category</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <!-- /Product Details -->
        </div>

        <!-- Product Tab -->
        <div class="row">
            <div class="col-md-12">
                <div id="product-tab">
                    <ul class="tab-nav">
                        <li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="tab1" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><?php echo e($product->description ?? 'No description available.'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Reviews Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>Customer Reviews</h3>
                <?php if(isset($reviews) && $reviews->isNotEmpty()): ?>
                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <strong><?php echo e($review->user->name); ?></strong>
                                <span class="text-muted">– <?php echo e($review->created_at->diffForHumans()); ?></span>
                                <div class="mb-1">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="fa fa-star<?php echo e($i <= $review->rating ? '' : '-o'); ?>" style="color: orange;"></i>
                                    <?php endfor; ?>
                                </div>
                                <p><?php echo e($review->content); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p>Belum ada ulasan untuk produk ini.</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- /Product Reviews Section -->



    </div>
</div>
<!-- /SECTION -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\WEB PROJEK\laravel-bengkel\resources\views/frontend/detailproduct.blade.php ENDPATH**/ ?>