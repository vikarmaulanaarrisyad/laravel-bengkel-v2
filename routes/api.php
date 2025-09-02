<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Raja Ongkir v2 API
Route::get('/rajaongkir/provinces', [App\Http\Controllers\RajaOngkirController::class, 'provinces']);
Route::get('/rajaongkir/cities', [App\Http\Controllers\RajaOngkirController::class, 'cities']);
Route::get('/rajaongkir/subdistricts', [App\Http\Controllers\RajaOngkirController::class, 'subdistricts']);
Route::post('/rajaongkir/cost', [App\Http\Controllers\RajaOngkirController::class, 'cost']);
