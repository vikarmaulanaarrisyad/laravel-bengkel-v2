<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TrackingController extends Controller
{
    public function track1()
    {
        $client = new Client();

        try {
            $response = $client->request('POST', 'https://rajaongkir.komerce.id/api/v1/track/waybill', [
                'headers' => [
                    'accept' => 'application/json',
                    'key' => '1vV2oHQwc7bd6d0953131ef4qXGm7eXo',
                ],
                'form_params' => [
                    'awb' => 'wahana', // ganti dengan nomor resi asli
                    'courier' => 'wahana'
                ]
            ]);

            $body = json_decode($response->getBody(), true);

            return response()->json($body);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function ajaxTracking(Request $request)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->request('POST', 'https://rajaongkir.komerce.id/api/v1/track/waybill', [
                'headers' => [
                    'accept' => 'application/json',
                    'key' => '1vV2oHQwc7bd6d0953131ef4qXGm7eXo',
                ],
                'form_params' => [
                    'awb' => $request->input('awb'),
                    'courier' => $request->input('courier')
                ]
            ]);

            $body = json_decode($response->getBody(), true);
            $manifest = $body['data']['manifest'] ?? [];

            return response()->json([
                'success' => true,
                'manifest' => $manifest
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data tracking: ' . $e->getMessage()
            ]);
        }
    }


    public function index()
    {
        return view('tracking.index');
    }

    public function track2(Request $request)
    {
        $client = new Client();

        try {
            $response = $client->request('POST', 'https://rajaongkir.komerce.id/api/v1/track/waybill', [
                'headers' => [
                    'accept' => 'application/json',
                    'key' => '1vV2oHQwc7bd6d0953131ef4qXGm7eXo',
                ],
                'form_params' => [
                    'awb' => $request->input('awb'),     // ambil dari form
                    'courier' => $request->input('courier') // misal: jne, jnt, wahana
                ]
            ]);

            $body = json_decode($response->getBody(), true);
            $trackingData = $body['data']['summary'] ?? [];
            $events = $body['data']['details'] ?? [];
            $manifest = $body['data']['manifest'] ?? [];

            return view('tracking.result', compact('trackingData', 'events', 'manifest'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal melacak: ' . $e->getMessage()]);
        }
    }

    public function track(Request $request)
    {
        $request->validate([
            'awb' => 'required|string',
            'courier' => 'required|string',
        ]);

        $client = new Client();

        try {
            $response = $client->request('POST', 'https://rajaongkir.komerce.id/api/v1/track/waybill', [
                'headers' => [
                    'accept' => 'application/json',
                    'key' => '1vV2oHQwc7bd6d0953131ef4qXGm7eXo',
                ],
                'form_params' => [
                    'awb' => $request->input('awb'),
                    'courier' => $request->input('courier')
                ]
            ]);

            $body = json_decode($response->getBody(), true);
            $summary = $body['data']['summary'] ?? [];
            $details = $body['data']['details'] ?? [];
            $delivery = $body['data']['delivery_status'] ?? [];
            $manifest = $body['data']['manifest'] ?? [];

            // Simpan ke database
            $order = Order::updateOrCreate(
                ['awb' => $request->awb],
                [
                    'courier' => $request->courier,
                    'service_code' => $summary['service_code'] ?? null,
                    'status' => $summary['status'] ?? null,

                    'waybill_number' => $details['waybill_number'] ?? null,
                    'waybill_date' => $details['waybill_date'] ?? null,
                    'waybill_time' => $details['waybill_time'] ?? null,
                    'weight' => $details['weight'] ?? null,
                    'origin' => $details['origin'] ?? null,
                    'destination' => $details['destination'] ?? null,

                    'shipper_name' => $details['shipper_name'] ?? null,
                    'shipper_address1' => $details['shipper_address1'] ?? null,
                    'shipper_address2' => $details['shipper_address2'] ?? null,
                    'shipper_address3' => $details['shipper_address3'] ?? null,
                    'shipper_city' => $details['shipper_city'] ?? null,

                    'receiver_name' => $details['receiver_name'] ?? null,
                    'receiver_address1' => $details['receiver_address1'] ?? null,
                    'receiver_address2' => $details['receiver_address2'] ?? null,
                    'receiver_address3' => $details['receiver_address3'] ?? null,
                    'receiver_city' => $details['receiver_city'] ?? null,

                    'pod_receiver' => $delivery['pod_receiver'] ?? null,
                    'pod_date' => $delivery['pod_date'] ?? null,
                    'pod_time' => $delivery['pod_time'] ?? null,

                    'manifest' => json_encode($manifest)
                ]
            );

            return view('tracking.result', compact('summary', 'details', 'delivery', 'manifest', 'order'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal melacak: ' . $e->getMessage()]);
        }
    }

    public function simulate(Request $request)
    {
        $awb = $request->input('awb');
        $courier = $request->input('courier');
        $status = strtoupper($request->input('status', 'DELIVERED')); // default status: DELIVERED

        $today = now();

        $manifestByStatus = [
            'DELIVERED' => [
                ['-5 days', 'Paket diterima di counter asal'],
                ['-4 days', 'Paket dalam perjalanan menuju HUB kota tujuan'],
                ['-3 days', 'Paket tiba di HUB kota tujuan'],
                ['-2 days', 'Paket dalam proses pengantaran ke alamat penerima'],
                ['-1 days', 'Paket telah diterima oleh penerima'],
            ],
            'ON_PROCESS' => [
                ['-3 days', 'Paket diterima di counter asal'],
                ['-2 days', 'Paket dalam perjalanan menuju HUB kota tujuan'],
                ['-1 days', 'Paket tiba di HUB kota tujuan'],
            ],
            'FAILED' => [
                ['-3 days', 'Paket diterima di counter asal'],
                ['-2 days', 'Paket tidak dapat dikirim karena alamat tidak ditemukan'],
                ['-1 days', 'Pengiriman gagal, akan dilakukan percobaan ulang'],
            ]
        ];

        $manifest = [];
        foreach ($manifestByStatus[$status] ?? [] as $step) {
            $date = $today->copy()->modify($step[0]);
            $manifest[] = [
                'manifest_date' => $date->format('Y-m-d'),
                'manifest_time' => $date->format('H:i:s'),
                'manifest_description' => $step[1]
            ];
        }

        return response()->json([
            'success' => true,
            'awb' => $awb,
            'courier' => strtoupper($courier),
            'status' => $status,
            'manifest' => $manifest
        ]);
    }
}
