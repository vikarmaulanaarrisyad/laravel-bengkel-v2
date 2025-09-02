@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="container-fluid">
	<h1 class="mb-4">Laporan Penjualan</h1>
	<div class="card">
		<div class="card-body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Nama Pembeli</th>
						<th>Produk</th>
						<th>Qty</th>
						<th>Total</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					@forelse($penjualan as $order)
						@foreach($order->orderDetail as $detail)
						<tr>
							<td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
							<td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
							<td>{{ $order->user->name ?? '-' }}</td>
							<td>{{ $detail->product->name ?? '-' }}</td>
							<td>{{ $detail->qty }}</td>
							<td>Rp{{ number_format($detail->qty * $detail->product->price, 0, ',', '.') }}</td>
							<td><span class="badge badge-{{ $order->statusColor() }}">{{ $order->status }}</span></td>
						</tr>
						@endforeach
					@empty
						<tr>
							<td colspan="7" class="text-center">Tidak ada data penjualan</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
