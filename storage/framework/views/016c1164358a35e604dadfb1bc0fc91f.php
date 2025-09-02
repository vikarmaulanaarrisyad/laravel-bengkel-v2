  <?php
      $categories = \App\Models\Category::inRandomOrder()->limit(5)->get();
  ?>

  <nav id="navigation">
      <!-- container -->
      <div class="container">
          <!-- responsive-nav -->
          <div id="responsive-nav">
              <!-- NAV -->
              <ul class="main-nav nav navbar-nav">
                  <li class="active"><a href="<?php echo e(url('/')); ?>">Home</a></li>
                  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li><a href="#"><?php echo e($category->name); ?></a></li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
              <!-- /NAV -->
          </div>
          <!-- /responsive-nav -->
      </div>
      <!-- /container -->
  </nav>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\frontend\nav.blade.php ENDPATH**/ ?>