@extends('layouts.front')

@section('content')
    @php
        $reviews = \App\Models\Review::with('product', 'user')->latest()->take(10)->get();
    @endphp

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
                @forelse ($reviews as $review)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ $review->product?->name ?? 'Produk tidak tersedia' }}
                                </h5>

                                {{-- Rating bintang --}}
                                <p class="mb-2">
                                    <strong>Rating:</strong>
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            ⭐
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                    ({{ $review->rating }}/5)
                                </p>

                                {{-- Isi Review --}}
                                <p class="card-text">
                                    {{ $review->content }}
                                </p>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <small class="text-muted">
                                    Oleh: {{ $review->user?->name ?? 'Anonim' }} <br>
                                    <em>{{ $review->created_at->diffForHumans() }}</em>
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <p class="text-center">Belum ada review yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
