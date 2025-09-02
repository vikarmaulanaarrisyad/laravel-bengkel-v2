<?php $__env->startSection('content'); ?>
    <?php
        $categories = \App\Models\Category::all();
        $maxPrice = ceil(\App\Models\Product::max('price') / 10000) * 10000;
        $priceSteps = range(0, $maxPrice, 10000);

        $newProduct = \App\Models\Product::query()
            ->when(request('search'), fn($q) => $q->where('name', 'like', '%' . request('search') . '%'))
            ->when(request('category'), fn($q) => $q->where('category_id', request('category')))
            ->when(request('min_price'), fn($q) => $q->where('price', '>=', request('min_price')))
            ->when(request('max_price'), fn($q) => $q->where('price', '<=', request('max_price')))
            ->when(request('sort'), fn($q) => $q->orderBy('price', request('sort') == 'asc' ? 'asc' : 'desc'))
            ->where('stock', '>', 0)
            ->with('category')
            ->paginate(12)
            ->withQueryString();
    ?>

    <div class="section">
        <div class="container">
            <div class="row">
                <!-- Section Title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">New Products</h3>
                        <div class="section-nav">
                            <ul class="section-tab-nav tab-nav">
                                <?php $__currentLoopData = $categories->shuffle()->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a data-toggle="tab" href="#tab1"><?php echo e($category->name); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Filter Form -->
                <div class="col-md-12">
                    <form method="GET" action="<?php echo e(route('front.index')); ?>" class="mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <input type="text" name="search" class="form-control" placeholder="Cari produk..."
                                    value="<?php echo e(request('search')); ?>">
                            </div>
                            <div class="col-md-2">
                                <select name="category" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>"
                                            <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                            <?php echo e($category->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="min_price" class="form-control">
                                    <option value="">Harga Min</option>
                                    <?php $__currentLoopData = $priceSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($step); ?>"
                                            <?php echo e(request('min_price') == $step ? 'selected' : ''); ?>>
                                            Rp <?php echo e(number_format($step, 0, ',', '.')); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="max_price" class="form-control">
                                    <option value="">Harga Max</option>
                                    <?php $__currentLoopData = $priceSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($step); ?>"
                                            <?php echo e(request('max_price') == $step ? 'selected' : ''); ?>>
                                            Rp <?php echo e(number_format($step, 0, ',', '.')); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="sort" class="form-control">
                                    <option value="">Urutkan Harga</option>
                                    <option value="asc" <?php echo e(request('sort') == 'asc' ? 'selected' : ''); ?>>Termurah
                                    </option>
                                    <option value="desc" <?php echo e(request('sort') == 'desc' ? 'selected' : ''); ?>>Termahal
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                            <div class="col-md-1">
                                <a href="<?php echo e(route('front.index')); ?>" class="btn btn-primary w-100">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Produk -->
                <div class="col-md-12">
                    <div class="row">
                        <?php $__empty_1 = true; $__currentLoopData = $newProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="product">
                                    <a href="<?php echo e(route('front.detail_product', ['slug' => $product->slug])); ?>">
                                        <div class="product-img">
                                            <img src="<?php echo e(Storage::url($product->path_image)); ?>" alt=""
                                                style="height: 200px; object-fit: contain;">
                                            <div class="product-label">
                                                <span class="new">NEW</span>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="product-body">
                                        <p class="product-category"><?php echo e($product->category?->name ?? 'Tanpa Kategori'); ?></p>
                                        <h3 class="product-name">
                                            <a href="<?php echo e(route('front.detail_product', ['slug' => $product->slug])); ?>">
                                                <?php echo e($product->name); ?>

                                            </a>
                                        </h3>
                                        <h4 class="product-price">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></h4>
                                    </div>
                                    <div class="add-to-cart">
                                        <?php if($product->stock > 0): ?>
                                            <button onclick="addToCart(<?php echo e($product->id); ?>)" class="add-to-cart-btn">
                                                <i class="fa fa-shopping-cart"></i> add to cart
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-md-12">
                                <p class="text-center">Tidak ada produk ditemukan.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-center">
                            <?php echo e($newProduct->links()); ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views/welcome.blade.php ENDPATH**/ ?>