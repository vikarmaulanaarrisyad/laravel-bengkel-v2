<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
        <div class="col-md-8 col-lg-6">
            <div class="login d-flex align-items-center py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 col-lg-8 mx-auto">
                            <a href="<?php echo e(url('/')); ?>">
                                <?php if($setting->path_image): ?>
                                    <img src="<?php echo e(Storage::url($setting->path_image)); ?>" alt="" class="w-50 mb-4">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('/img/logo.png')); ?>" alt="" class="w-50 mb-4">
                                <?php endif; ?>
                            </a>
                            <h4 class="login-heading mb-4">Selamat Datang Kembali!</h4>

                            
                            <form id="loginForm" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form-group mb-3">
                                    <label for="auth">Email / Username</label>
                                    <input type="text" class="form-control" id="auth" name="auth" autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control password" id="password" name="password" autocomplete="off">
                                </div>

                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox" id="showPassword">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label for="customCheck1" class="custom-control-label">Show Password</label>
                                    </div>
                                </div>

                                <button type="button" onclick="login()" id="loginButton" class="btn btn-lg btn-primary btn-login mb-2">
                                    <i class="fas fa-sign-in-alt"></i> <span id="buttonText">Masuk</span>
                                    <span id="loadingSpinner" style="display:none;"><i class="fas fa-spinner fa-spin"></i></span>
                                </button>

                                <div class="text-center mt-3">
                                    <div class="text-muted">
                                        Jika belum punya akun silahkan registrasi
                                        <a href="<?php echo e(route('register')); ?>" class="text-muted">disini</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Set CSRF token untuk semua Ajax request
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Enter key submit
    $(document).on('keypress', function(e){
        if(e.which == 13) login();
    });

    function login() {
        let auth = $('#auth').val();
        let password = $('.password').val();

        if(!auth){ toastr.info('Email atau username wajib diisi'); return; }
        if(!password){ toastr.info('Password wajib diisi'); return; }

        const loginButton = $('#loginButton');
        const buttonText = $('#buttonText');
        const loadingSpinner = $('#loadingSpinner');

        loginButton.attr('disabled', true);
        buttonText.hide();
        loadingSpinner.show();

        $.ajax({
            type: 'POST',
            url: '<?php echo e(route('login')); ?>',
            data: { auth: auth, password: password },
            success: function(response){
                Swal.fire({
                    icon: 'success',
                    title: 'Login berhasil',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                }).then(()=> window.location.href = '<?php echo e(route("dashboard")); ?>');
            },
            error: function(errors){
                toastr.error(errors.responseJSON.message);
            },
            complete: function(){
                loginButton.attr('disabled', false);
                buttonText.show();
                loadingSpinner.hide();
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\auth\login.blade.php ENDPATH**/ ?>