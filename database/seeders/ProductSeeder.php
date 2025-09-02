<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menyusun data produk berdasarkan kategori
        $products = [
            // Kategori Sparepart Motor
            'Mesin' => [
                ['name' => 'Mesin Motor Yamaha', 'price' => 1500000, 'description' => 'Mesin motor Yamaha untuk berbagai tipe', 'stock' => 10],
                ['name' => 'Kopling Motor Honda', 'price' => 500000, 'description' => 'Kopling motor Honda untuk berbagai model', 'stock' => 15],
            ],
            'Sistem Pengapian' => [
                ['name' => 'Busi Motor Suzuki', 'price' => 150000, 'description' => 'Busi motor Suzuki untuk performa maksimal', 'stock' => 30],
            ],
            // Kategori Sparepart Mobil
            'Mesin dan Komponen Utama' => [
                ['name' => 'Mesin Mobil Toyota', 'price' => 5000000, 'description' => 'Mesin mobil Toyota untuk tipe sedan', 'stock' => 5],
                ['name' => 'Kopling Mobil Honda', 'price' => 1000000, 'description' => 'Kopling mobil Honda untuk tipe hatchback', 'stock' => 12],
            ],
            'Suspensi dan Peredam Kejut' => [
                ['name' => 'Suspensi Mobil Nissan', 'price' => 2000000, 'description' => 'Suspensi mobil Nissan tipe SUV', 'stock' => 8],
            ]
        ];

        // Insert produk ke dalam tabel
        foreach ($products as $categoryName => $categoryProducts) {
            $category = Category::where('name', $categoryName)->first();
            foreach ($categoryProducts as $productData) {
                Product::create([
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'slug' => Str::slug($productData['name']),
                    'category_id' => 1, // Relasi ke kategori
                ]);
            }
        }
    }
}
