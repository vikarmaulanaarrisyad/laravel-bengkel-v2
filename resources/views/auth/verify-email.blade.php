@extends('layouts.front')

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="alert alert-info">
            <h4 class="mb-3">Verifikasi Email Diperlukan</h4>
            <p>
                Sebelum melanjutkan, silakan periksa email Anda dan klik link verifikasi yang telah dikirim.
                Jika Anda tidak menerima email, klik tombol di bawah ini untuk mengirim ulang.
            </p>

            @if (session('message'))
                <div class="alert alert-success mt-3">
                    {{ session('message') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-primary">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>
        </div>
    </div>
@endsection
