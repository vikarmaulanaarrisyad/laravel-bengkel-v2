@extends('layouts.front')

@section('content')
    {{--  @php
        $reviews = \App\Models\Review::with('product', 'user')
            ->latest()
            ->take(10)
            ->get();
    @endphp  --}}

    <div class="section">
        <div class="container">
            <div class="row">
                <!-- Judul Halaman -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Review Produk Terbaru</h3>
                    </div>
                </div>

                <!-- List Review -->
                {{--  @forelse ($reviews as $review)  --}}
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <p class="card-text">
                                    <strong>Rating:</strong> ⭐/ 5<br>
                                    <strong>Review:</strong>
                                </p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Oleh: </small>
                            </div>
                        </div>
                    </div>
                {{--  @empty  --}}
                    <div class="col-md-12">
                        <p class="text-center">Belum ada review yang tersedia.</p>
                    </div>
                {{--  @endforelse  --}}
            </div>
        </div>
    </div>
@endsection
