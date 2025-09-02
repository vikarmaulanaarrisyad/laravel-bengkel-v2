@extends('layouts.app')

@section('title', 'Edit Stok Offline')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Edit Stok Offline</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('stokoffline.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" class="form-control" value="{{ $product->name }}" readonly>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" class="form-control" value="{{ $product->category->name ?? '-' }}" readonly>
                </div>
                <div class="form-group">
                    <label>Stok Offline</label>
                    <input type="number" name="stok_offline" class="form-control" value="{{ $product->stok_offline ?? 0 }}" min="0" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('stokoffline.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection