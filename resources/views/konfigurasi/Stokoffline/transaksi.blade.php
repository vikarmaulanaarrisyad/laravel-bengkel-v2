@extends('layouts.app')

@section('title', 'Transaksi Offline')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Transaksi Offline</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('stokoffline.transaksi') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="product_id">Pilih Produk</label>
                    <select name="product_id" id="product_id" class="form-control" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stok_offline }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="qty">Jumlah Pembelian</label>
                    <input type="number" name="qty" id="qty" class="form-control" min="1" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan Transaksi</button>
            </form>
        </div>
    </div>
</div>
@endsection
