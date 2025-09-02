@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Generate Nomor Resi Palsu & Simulasi Tracking</h1>

        <p>Order ID: {{ $order->id }}</p>
        <p>Current AWB: {{ $order->awb ?? '-' }}</p>
        <p>Current Courier: {{ ucfirst($order->courier) ?? '-' }}</p>

        @if (session('success'))
            <div style="color: green; margin-bottom: 1rem;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="color: red; margin-bottom: 1rem;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.fake-resi.create') }}" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <label for="courier">Pilih Kurir:</label>
            <select name="courier" id="courier" required>
                <option value="">-- Pilih Kurir --</option>
                <option value="jne">JNE</option>
                <option value="jnt">JNT</option>
                <option value="tiki">TIKI</option>
                <option value="sicepat">SiCepat</option>
                <option value="anteraja">Anteraja</option>
                <option value="wahana">Wahana</option>
            </select>

            <br><br>
            <button type="submit">Generate Nomor Resi Palsu & Simulasi Tracking</button>
        </form>
    </div>
@endsection
