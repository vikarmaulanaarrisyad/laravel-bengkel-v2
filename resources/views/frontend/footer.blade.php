 @php
     $categories = \App\Models\Category::get();
     $setting = \App\Models\Setting::first();
 @endphp

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
                             {{ $setting->about }}
                         </p>
                         <ul class="footer-links">
                             <li><a href="#"><i class="fa fa-map-marker"></i>{{ $setting->address }}</a></li>
                             <li><a href="#"><i class="fa fa-phone"></i>{{ $setting->phone }}</a></li>
                             <li><a href="#"><i class="fa fa-envelope-o"></i>{{ $setting->email }}</a></li>
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
