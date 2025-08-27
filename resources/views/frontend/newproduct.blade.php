@php
    $newProduct = \App\Models\Product::orderBy('created_at', 'desc')->take(10)->with('category')->get();
@endphp


<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">


            <!-- Products tab & slick -->
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <!-- tab -->
                        <div id="tab1" class="tab-pane active">
                            <div class="products-slick" data-nav="#slick-nav-1">
                                <!-- product -->
                                @foreach ($newProduct as $product)
                                    <div class="product">
                                        <a href="{{ route('front.detail_product', ['slug' => $product->slug]) }}
">
                                            <div class="product-img">
                                                <img src="{{ Storage::url($product->path_image) }}" alt="">
                                                <div class="product-label">
                                                    <span class="new">NEW</span>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="product-body">
                                            <p class="product-category">{{ $product->category->name }}</p>
                                            <h3 class="product-name"><a
                                                    href="{{ route('front.detail_product', ['slug' => $product->slug]) }}">{{ $product->name }}</a>
                                                <h3 class="product-name"><a
                                                        href="#">{{ $product->description }}</a>
                                                </h3>
                                                <h4 class="product-price">Rp {{ format_uang($product->price) }}
                                                </h4>
                                        </div>
                                        <div class="add-to-cart">
                                            <input type="hidden" name="product_id" id="product_id">
                                            <button class="add-to-cart-btn" onclick="addToCart()"><i
                                                    class="fa
                                                fa-shopping-cart"></i>
                                                add
                                                to
                                                cart</button>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- /product -->
                            </div>
                            <div id="slick-nav-1" class="products-slick-nav"></div>
                        </div>
                        <!-- /tab -->
                    </div>
                </div>
            </div>
            <!-- Products tab & slick -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
