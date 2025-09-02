@extends('layouts.front')

@section('content')
    @php
        $categories = \App\Models\Category::all();
        $maxPrice = ceil(\App\Models\Product::max('price') / 10000) * 10000;
        $priceSteps = range(0, $maxPrice, 10000);

        $newProduct = \App\Models\Product::query()
            ->when(request('search'), fn($q) => $q->where('name', 'like', '%' . request('search') . '%'))
            ->when(request('category'), fn($q) => $q->where('category_id', request('category')))
            ->when(request('min_price'), fn($q) => $q->where('price', '>=', request('min_price')))
            ->when(request('max_price'), fn($q) => $q->where('price', '<=', request('max_price')))
            ->when(request('sort'), fn($q) => $q->orderBy('price', request('sort') == 'asc' ? 'asc' : 'desc'))
            ->where('stock', '>', 0)
            ->with('category')
            ->paginate(12)
            ->withQueryString();
    @endphp

    <div class="section">
        <div class="container">
            <div class="row">
                <!-- Section Title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">New Products</h3>
                        <div class="section-nav">
                            <ul class="section-tab-nav tab-nav">
                                @foreach ($categories->shuffle()->take(2) as $category)
                                    <li><a data-toggle="tab" href="#tab1">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Filter Form -->
                <div class="col-md-12">
                    <form method="GET" action="{{ route('front.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <input type="text" name="search" class="form-control" placeholder="Cari produk..."
                                    value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="category" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="min_price" class="form-control">
                                    <option value="">Harga Min</option>
                                    @foreach ($priceSteps as $step)
                                        <option value="{{ $step }}"
                                            {{ request('min_price') == $step ? 'selected' : '' }}>
                                            Rp {{ number_format($step, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="max_price" class="form-control">
                                    <option value="">Harga Max</option>
                                    @foreach ($priceSteps as $step)
                                        <option value="{{ $step }}"
                                            {{ request('max_price') == $step ? 'selected' : '' }}>
                                            Rp {{ number_format($step, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="sort" class="form-control">
                                    <option value="">Urutkan Harga</option>
                                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Termurah
                                    </option>
                                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Termahal
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                            <div class="col-md-1">
                                <a href="{{ route('front.index') }}" class="btn btn-primary w-100">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Produk -->
                <div class="col-md-12">
                    <div class="row">
                        @forelse ($newProduct as $product)
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="product">
                                    <a href="{{ route('front.detail_product', ['slug' => $product->slug]) }}">
                                        <div class="product-img">
                                            <img src="{{ Storage::url($product->path_image) }}" alt=""
                                                style="height: 200px; object-fit: contain;">
                                            <div class="product-label">
                                                <span class="new">NEW</span>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="product-body">
                                        <p class="product-category">{{ $product->category?->name ?? 'Tanpa Kategori' }}</p>
                                        <h3 class="product-name">
                                            <a href="{{ route('front.detail_product', ['slug' => $product->slug]) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        <h4 class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                                    </div>
                                    <div class="add-to-cart">
                                        @if ($product->stock > 0)
                                            <button onclick="addToCart({{ $product->id }})" class="add-to-cart-btn">
                                                <i class="fa fa-shopping-cart"></i> add to cart
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12">
                                <p class="text-center">Tidak ada produk ditemukan.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-center">
                            {{ $newProduct->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
