@extends('layouts.front')

@section('content')
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">All Categories</a></li>
                    @if ($product && $product->category && $product->category->name)
                        <li><a href="#">{{ $product->category->name }}</a></li>
                    @else
                        <li><a href="#">Category Not Available</a></li>
                    @endif
                    <li class="active">{{ $product->name ?? 'Product Not Available' }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-md-5">
                <div id="product-imgs">
                    <div class="product-preview">
                        <img src="{{ Storage::url($product->path_image) }}" alt="{{ $product->name ?? 'Image' }}" class="img-responsive" style="max-width:100%;">
                    </div>
                </div>
            </div>
            <!-- /Product Images -->

            <!-- Product Details -->
            <div class="col-md-7">
                <div class="product-details">
                    <h2 class="product-name">{{ $product->name ?? 'Product Not Available' }}</h2>
                    <div>
                        <h3 class="product-price">Rp. {{ format_uang($product->price ?? 0) }}</h3>
                        <span class="product-available">In Stock: {{ $product->stock ?? 'N/A' }}</span>
                    </div>
                    <p>{{ $product->description ?? 'No description available.' }}</p>

                    <div class="add-to-cart">
                        <button onclick="addToCart({{ $product->id ?? 0 }})" class="add-to-cart-btn">
                            <i class="fa fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>

                    <ul class="product-links">
                        <li>Category:</li>
                        @if ($product && $product->category && $product->category->name)
                            <li><a href="#">{{ $product->category->name }}</a></li>
                        @else
                            <li><a href="#">No Category</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <!-- /Product Details -->
        </div>

        <!-- Product Tab -->
        <div class="row">
            <div class="col-md-12">
                <div id="product-tab">
                    <ul class="tab-nav">
                        <li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="tab1" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>{{ $product->description ?? 'No description available.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Reviews Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>Customer Reviews</h3>
                @if(isset($reviews) && $reviews->isNotEmpty())
                    @foreach($reviews as $review)
                        <div class="card mb-3">
                            <div class="card-body">
                                <strong>{{ $review->user->name }}</strong>
                                <span class="text-muted">– {{ $review->created_at->diffForHumans() }}</span>
                                <div class="mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star{{ $i <= $review->rating ? '' : '-o' }}" style="color: orange;"></i>
                                    @endfor
                                </div>
                                <p>{{ $review->content }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Belum ada ulasan untuk produk ini.</p>
                @endif
            </div>
        </div>
        <!-- /Product Reviews Section -->



    </div>
</div>
<!-- /SECTION -->
@endsection
