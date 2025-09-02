<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RajaOngkirService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Tambahkan untuk debugging jika perlu

class RajaOngkirController extends Controller
{
    protected $rajaOngkir;

    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }

    public function provinces()
    {
        return response()->json($this->rajaOngkir->getProvinces());
    }

    public function cities(Request $request)
    {
        $provinceId = $request->get('province_id');
        $cities = $this->rajaOngkir->getCities($provinceId);
        return response()->json(['data' => $cities]);
    }

    public function subdistricts(Request $request)
    {
        $cityId = $request->get('city_id');
        return response()->json($this->rajaOngkir->getSubdistricts($cityId));
    }

  public function getCost(Request $request)
    {
    $validated = $request->validate([
            'origin_id'      => 'required|integer',
            'destination_id' => 'required|integer',
            'weight'         => 'required|integer',
            'courier'        => 'required|string',
        ]);

        try {
            // ==========================================================
            $response = Http::asForm()->withHeaders([
                'key' => env('RAJAONGKIR_API_KEY'),
            ])->post('https://rajaongkir.komerce.id/api/v1/calculate/district/domestic-cost', [
                'origin'        => $validated['origin_id'],
                'destination'   => $validated['destination_id'],
                'weight'        => $validated['weight'],
                'courier'       => $validated['courier'],
            ]);

            if ($response->successful() && isset($response->json()['meta']['status']) && $response->json()['meta']['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'data' => $response->json()['data'],
                ]);
            }

            $errorMessage = $response->json()['meta']['message'] ?? 'Gagal mengambil data ongkir.';
            return response()->json(['status' => 'error', 'message' => $errorMessage], 400);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Tidak dapat terhubung ke server Komerce.'], 500);
        }
    }

}

