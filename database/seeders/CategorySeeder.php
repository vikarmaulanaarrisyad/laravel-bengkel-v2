<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategori Sparepart Motor
        $motorCategories = [
            'Mesin',
            'Sistem Pengapian',
            'Sistem Pembuangan',
            'Sistem Pendingin',
            'Suspensi dan Peredam Kejut',
            'Rem',
            'Elektrikal dan Aksesori Lain',
            'Rangka dan Body',
            'Ban dan Velg',
            'Aksesoris'
        ];

        // Kategori Sparepart Mobil
        $mobilCategories = [
            'Mesin dan Komponen Utama',
            'Sistem Pengapian',
            'Sistem Pembuangan',
            'Sistem Pendingin',
            'Sistem Rem',
            'Suspensi dan Peredam Kejut',
            'Transmisi dan Kopling',
            'Elektrikal dan Aksesori',
            'Interior dan Eksterior',
            'Ban dan Velg',
            'Kelengkapan dan Alat Servis'
        ];

        // Insert kategori mobil
        foreach ($motorCategories as $category) {
            Category::create([
                'name' => $category,
                'ori_kw_second' => 'ori',
                'slug' => Str::slug($category) // Membuat slug dari nama kategori
            ]);
        }

        foreach ($mobilCategories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category) // Membuat slug dari nama kategori
            ]);
        }
    }
}
