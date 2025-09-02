 <?php
     $categories = \App\Models\Category::get();
     $setting = \App\Models\Setting::first();
 ?>

 <footer id="footer">
     <!-- top footer -->
     <div class="section">
         <!-- container -->
         <div class="container">
             <!-- row -->
             <div class="row">
                 <div class="col-md-12 col-xs-12">
                     <div class="footer">
                         <h3 class="footer-title">About Us</h3>
                         <p>
                             <?php echo e($setting->about); ?>

                         </p>
                         <ul class="footer-links">
                             <li><a href="#"><i class="fa fa-map-marker"></i><?php echo e($setting->address); ?></a></li>
                             <li><a href="#"><i class="fa fa-phone"></i><?php echo e($setting->phone); ?></a></li>
                             <li><a href="#"><i class="fa fa-envelope-o"></i><?php echo e($setting->email); ?></a></li>
                         </ul>
                     </div>
                 </div>
             </div>
             <!-- /row -->
         </div>
         <!-- /container -->
     </div>
     <!-- /top footer -->

     <!-- bottom footer -->
     <div id="bottom-footer" class="section">
         <div class="container">
             <!-- row -->
             <div class="row">
                 <div class="col-md-12 text-center">
                     <span class="copyright">
                         <script>
                             document.write(new Date().getFullYear());
                         </script> All rights reserved
                     </span>
                 </div>
             </div>
             <!-- /row -->
         </div>
         <!-- /container -->
     </div>
     <!-- /bottom footer -->
 </footer>
<?php /**PATH C:\Users\Lenovo\Downloads\laravel-bengkel-v2\resources\views\frontend\footer.blade.php ENDPATH**/ ?>