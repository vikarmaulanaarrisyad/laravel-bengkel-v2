<aside class="main-sidebar elevation-4 sidebar-light-info">
    <!-- Brand Logo -->
    <a href="<?php echo e(url('/')); ?>" class="brand-link">
        <img src="<?php echo e(Storage::url($setting->path_image ?? '')); ?>" alt="Logo"
            class="brand-image img-circle elevation-3 bg-light" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo e($setting->company_name); ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php if(!empty(auth()->user()->path_image) && Storage::disk('public')->exists(auth()->user()->path_image)): ?>
                    <img src="<?php echo e(Storage::url(auth()->user()->path_image)); ?>" alt="logo"
                        class="img-circle elevation-2" style="width: 35px; height: 35px;">
                <?php else: ?>
                    <img src="<?php echo e(asset('AdminLTE/dist/img/user1-128x128.jpg')); ?>" alt="logo"
                        class="img-circle elevation-2" style="width: 35px; height: 35px;">
                <?php endif; ?>
            </div>
            <div class="info">
                <a href="<?php echo e(route('profile.show')); ?>" class="d-block" data-toggle="tooltip" data-placement="top"
                    title="Edit Profil">
                    <?php echo e(auth()->user()->name); ?>

                    <i class="fas fa-pencil-alt ml-2 text-sm text-primary"></i>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Dashboard Index')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('dashboard')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(auth()->user()->hasRole('Admin')): ?>
                    <li class="nav-header">MASTER DATA</li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Category Index')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('category.index')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                Data Kategori
                            </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Product Index')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('products.index')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-cube"></i>
                            <p>
                                Produk
                            </p>
                        </a>
                    </li>
                <?php endif; ?>


                <li class="nav-item">
                    <a href="<?php echo e(route('laporanpenjualan.index')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Laporan Penjualan</p>
                    </a>
                </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('stokoffline.index')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>Stok Offline</p>
                        </a>
                    </li>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Pembelian Index')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('orders.index')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-cart-plus"></i>
                            <p>
                                Laporan Pembelian
                            </p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Konfigurasi Index')): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Konfigurasi
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview" style="display: none">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('User Index')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('users.index')); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>User</p>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Role Index')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('role.index')); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Role</p>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Permission Index')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('permission.index')); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Permission</p>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Group Permission Index')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('permissiongroups.index')); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Group Permission</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Pengaturan Index')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('setting.index')); ?>"
                            class="nav-link <?php echo e(request()->is('setting*') ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Pengaturan
                            </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('StockOffline Index')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('stockoffline.index')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>Stok Offline</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</aside>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\layouts\partials\sidebar.blade.php ENDPATH**/ ?>