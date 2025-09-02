<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('rajaongkir.api_key');
        $this->baseUrl = config('rajaongkir.base_url', 'https://rajaongkir.komerce.id/api/v1');
    }

    public function getProvinces()
    {
        $url = "{$this->baseUrl}/destination/province";
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($url);
        return $response->json();
    }

    public function getCities($provinceId)
    {
        $url = "{$this->baseUrl}/destination/city/{$provinceId}";
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'key' => $this->apiKey
        ])->get($url);
        
        if ($response->successful()) {
            $result = $response->json();
            Log::info('City Response:', $result); // Debug log
            
            if (isset($result['meta']) && $result['meta']['status'] === 'success') {
                // Data langsung dari response
                $cities = $result['data'] ?? [];
                // Sort cities by name
                $cities = collect($cities)->sortBy('name')->values()->all();
                return ['data' => ['data' => $cities]];
            }
        }
        
        Log::error('City Error Response:', $response->json()); // Debug error
        return ['data' => ['data' => []]];
    }

    public function getSubdistricts($cityId)
    {
        $url = "{$this->baseUrl}/destination/district/{$cityId}";
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'key' => $this->apiKey
        ])->get($url);
        
        if ($response->successful()) {
            $result = $response->json();
            Log::info('District Response:', $result); // Debug log
            
            if (isset($result['meta']) && $result['meta']['status'] === 'success') {
                // Data langsung dari response
                $districts = $result['data'] ?? [];
                // Sort districts by name
                $districts = collect($districts)->sortBy('name')->values()->all();
                return ['data' => ['data' => $districts]];
            }
        }
        
        Log::error('District Error Response:', $response->json()); // Debug error
        return ['data' => ['data' => []]];
    }

    public function getCost($origin, $originType, $destination, $destinationType, $weight, $courier)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->post("{$this->baseUrl}/cost", [
            'origin' => $origin,
            'originType' => $originType,
            'destination' => $destination,
            'destinationType' => $destinationType,
            'weight' => $weight,
            'courier' => $courier
        ]);
        return $response->json();
    }
}
