@extends('layouts.app')

@section('title', 'Stok Offline')

@section('content')
<div class="container-fluid">
	@if(session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
	@endif
	<h1 class="mb-4">Stok Offline</h1>
	<div class="row mb-3">
		<div class="col-md-6">
			<div class="card card-info">
				<div class="card-body">
					<strong>Total Produk:</strong> {{ $products->count() }}<br>
					<strong>Total Stok Offline:</strong> {{ $products->sum('stok_offline') }}
				</div>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Produk</th>
						<th>Kategori</th>
						<th>Stok Offline</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					@forelse($products as $product)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $product->name }}</td>
							<td>{{ $product->category->name ?? '-' }}</td>
							<td>{{ $product->stok_offline ?? 0 }}</td>
							<td>
								<a href="{{ route('stokoffline.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="4" class="text-center">Tidak ada data produk</td>
								<td></td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
