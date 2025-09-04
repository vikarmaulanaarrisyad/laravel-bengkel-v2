<div id="top-header">
    <div class="container">
        <ul class="header-links pull-left">
            <li><a href="#"><i class="fa fa-phone"></i><?php echo e($setting->phone); ?></a></li>
            <li><a href="#"><i class="fa fa-envelope-o"></i><?php echo e($setting->email); ?></a></li>
            <li><a href="#"><i class="fa fa-map-marker"></i> <?php echo e($setting->address); ?></a></li>
        </ul>
        <ul class="header-links pull-right">
            <?php if(auth()->guard()->check()): ?>
                <li>
                    <a href="#">
                        <i class="fa fa-user-o"></i> Welcome, <?php echo e(auth()->user()->name); ?></span>
                    </a>
                </li>
                <li><a href="<?php echo e(route('front.checkout_history')); ?>"><i class="fa fa-history"></i> History Order</a></li>
                <li><a href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="fa fa-sign-out-alt"></i> Logout</a></li>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            <?php else: ?>
                <li><a href="<?php echo e(route('login')); ?>"><i class="fa fa-sign-in-alt"></i> Login</a></li>
                <li><a href="<?php echo e(route('register')); ?>"><i class="fa fa-sign-in-alt"></i> Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php /**PATH D:\WEB PROJEK\laravel-bengkel\resources\views/frontend/topheader.blade.php ENDPATH**/ ?>