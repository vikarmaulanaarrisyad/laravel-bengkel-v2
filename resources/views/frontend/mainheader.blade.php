  @php
      $setting = \App\Models\Setting::first();
      $categories = \App\Models\Category::inRandomOrder()->limit(5)->get();
  @endphp

  <div id="header">
      <!-- container -->
      <div class="container">
          <!-- row -->
          <div class="row">
              <!-- LOGO -->
              <div class="col-md-3">
                  <div class="header-logo">
                      <a href="#" class="logo">
                          @if ($setting->path_image == 'default.jpg')
                              <img src="{{ asset('frontend') }}/img/logo.png" alt="">
                          @else
                              <img src="{{ Storage::url($setting->path_image) }}" alt="" width="80%"
                                  height="60%">
                          @endif
                      </a>
                  </div>
              </div>
              <!-- /LOGO -->

              <!-- SEARCH BAR -->
              <div class="col-md-6">
                  <div class="header-search">
                      <form style="display: none">
                          <select class="input-select">
                              <option value="">All Categories</option>
                              @foreach ($categories as $category)
                                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                              @endforeach
                          </select>
                          <input class="input" placeholder="Search here">
                          <button class="search-btn">Search</button>
                      </form>
                  </div>
              </div>
              <!-- /SEARCH BAR -->

              <!-- ACCOUNT -->
              <div class="col-md-3 clearfix">
                  <div class="header-ctn">
                      <!-- Cart -->
                      <div class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                              <i class="fa fa-shopping-cart"></i>
                              <span>Your Cart</span>
                              <div id="cartQty" class="qty">0</div>
                          </a>
                          <div class="cart-dropdown">
                              <div id="miniCart"></div>

                              <div class="cart-summary">
                                  <small id="itemSelect"> 0</small>
                                  <h5 id="cartSubTotal">0</h5>
                              </div>
                              <div class="cart-btns">
                                  <a href="#" style="display: none">View Cart</a>
                                  <a href="{{ route('front.checkout_index') }}">Checkout <i
                                          class="fa fa-arrow-circle-right"></i></a>
                              </div>
                          </div>
                      </div>
                      <!-- /Cart -->

                      <!-- Menu Toogle -->
                      <div class="menu-toggle">
                          <a href="#">
                              <i class="fa fa-bars"></i>
                              <span>Menu</span>
                          </a>
                      </div>
                      <!-- /Menu Toogle -->
                  </div>
              </div>
              <!-- /ACCOUNT -->
          </div>
          <!-- row -->
      </div>
      <!-- container -->
  </div>
