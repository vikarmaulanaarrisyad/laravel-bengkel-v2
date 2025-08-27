<h2 class="text-xl font-bold mb-4">Tracking Info</h2>
<p><strong>Nomor Resi:</strong> {{ $summary['waybill'] ?? '-' }}</p>
<p><strong>Kurir:</strong> {{ strtoupper($summary['courier_name']) ?? '-' }}</p>
<p><strong>Asal:</strong> {{ $summary['origin'] ?? '-' }}</p>
<p><strong>Tujuan:</strong> {{ $summary['destination'] ?? '-' }}</p>
<p><strong>Status:</strong> {{ $summary['status'] ?? '-' }}</p>

<hr class="my-4">

<h3 class="text-lg font-semibold">Riwayat Perjalanan:</h3>
<table class="table-auto w-full border mt-2">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 border">Tanggal & Waktu</th>
            <th class="px-4 py-2 border">Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach (json_decode($order->manifest, true) as $item)
            <li>
                {{ $item['manifest_date'] }} {{ $item['manifest_time'] }} -
                {{ $item['manifest_description'] }}
            </li>
        @endforeach

    </tbody>
</table>
