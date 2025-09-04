<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($setting->company_name); ?> - <?php echo $__env->yieldContent('title'); ?></title>

    <link rel="icon" href="<?php echo e(asset('/img/favicon.png')); ?>" type="image/*">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <?php echo $__env->yieldPushContent('css_vendor'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE')); ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE/plugins/toastr/toastr.min.css')); ?>">

    <?php echo $__env->yieldPushContent('css'); ?>


    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
        }

        .login {
            min-height: 100vh;
        }

        .bg-image {
            background-image: url('<?php echo e(Storage::url($setting->path_image_header)); ?>');
            background-size: cover;
            background-position: center;
        }

        .login-heading {
            font-weight: 300;
        }

        .login .form-control {
            height: calc(1.5em + 1rem + 2px);
            padding: 0.5rem 1rem;
            line-height: 1.5;
            border-radius: 0.3rem;
        }

        .btn-login {
            font-size: 0.9rem;
            letter-spacing: 0.05rem;
            padding: 0.75rem 1.5rem;
        }
    </style>
</head>

<body>

    <?php echo $__env->yieldContent('content'); ?>

    <script src="<?php echo e(asset('AdminLTE')); ?>/plugins/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts_vendor'); ?>
    <script src="<?php echo e(asset('AdminLTE/plugins/toastr/toastr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>
    <script src="<?php echo e(asset('AdminLTE')); ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script>
        // Show password
        $('#customCheck1').on('click', function() {
            if ($(this).is(':checked')) {
                $('.password').attr('type', 'text');
            } else {
                $('.password').attr('type', 'password');
            }
        })
    </script>

</body>

</html>
<?php /**PATH D:\WEB PROJEK\laravel-bengkel\resources\views/layouts/guest.blade.php ENDPATH**/ ?>