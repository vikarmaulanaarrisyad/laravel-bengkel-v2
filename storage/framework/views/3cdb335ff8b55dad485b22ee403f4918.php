<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($setting->company_name); ?> - <?php echo $__env->yieldContent('title'); ?></title>

    <link rel="icon" href="<?php echo e(Storage::url($setting->path_image ?? '')); ?>" type="image/*">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(asset('/AdminLTE/plugins/fontawesome-free/css/all.min.css')); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo e(asset('/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')); ?>">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo e(asset('/AdminLTE/plugins/jqvmap/jqvmap.min.css')); ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo e(asset('/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>">
    <!-- SweetAler2 -->
    <link rel="stylesheet" href="<?php echo e(asset('/AdminLTE/plugins/sweetalert2/sweetalert2.min.css')); ?>">
    <?php echo $__env->yieldPushContent('css_vendor'); ?>

    <!-- Theme style -->
    
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE/dist/css/adminlte.min.css?v=3.2.0')); ?>">

    <style>
        .note-editor {
            margin-bottom: 0;
        }

        .note-editor.is-invalid {
            border-color: var(--danger);
        }

        .nav-sidebar .nav-header {
            font-size: .6rem;
            font-weight: bold;
            color: #888;
        }

        .styleblock {
            display: block !important;
            /* Menampilkan dropdown dalam gaya blok */
        }

        #pendapatanChart {
            max-width: 100%;
            height: 300px;
            /* Sesuaikan tinggi grafik */
        }
    </style>

    <?php echo $__env->yieldPushContent('css'); ?>
</head>

<body class="sidebar-mini layout-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        

        <!-- Navbar -->
        <?php if ($__env->exists('layouts.partials.header')) echo $__env->make('layouts.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php if ($__env->exists('layouts.partials.sidebar')) echo $__env->make('layouts.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?php echo $__env->yieldContent('title'); ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php $__env->startSection('breadcrumb'); ?>
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <?php echo $__env->yieldSection(); ?>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

        <!-- /.content-wrapper -->
        <?php if ($__env->exists('layouts.partials.footer')) echo $__env->make('layouts.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?php echo e(asset('/AdminLTE/plugins/jquery/jquery.min.js')); ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo e(asset('/AdminLTE/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo e(asset('/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- ChartJS -->
    <script src="<?php echo e(asset('/AdminLTE/plugins/chart.js/Chart.min.js')); ?>"></script>
    <!-- Sparkline -->
    <script src="<?php echo e(asset('/AdminLTE/plugins/sparklines/sparkline.js')); ?>"></script>
    <!-- JQVMap -->
    <script src="<?php echo e(asset('/AdminLTE/plugins/jqvmap/jquery.vmap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js')); ?>"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo e(asset('/AdminLTE/plugins/jquery-knob/jquery.knob.min.js')); ?>"></script>
    <!-- daterangepicker -->
    <script src="<?php echo e(asset('/AdminLTE/plugins/moment/moment.min.js')); ?>"></script>

    <!-- overlayScrollbars -->
    <script src="<?php echo e(asset('/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')); ?>"></script>
    <!-- sweetalert2 -->
    <script src="<?php echo e(asset('/AdminLTE/plugins/sweetalert2/sweetalert2.all.min.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts_vendor'); ?>

    <!-- AdminLTE App -->
    <script src="<?php echo e(asset('AdminLTE/dist/js/adminlte.js?v=3.2.0')); ?>"></script>
    <script src="<?php echo e(asset('AdminLTE/dist/js/pages/dashboard.js')); ?>"></script>

    <script src="<?php echo e(asset('/js/custom.js')); ?>"></script>

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
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\layouts\app.blade.php ENDPATH**/ ?>