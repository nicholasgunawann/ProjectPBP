<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Ambil ID kategori berdasarkan nama
        $pakaianId = DB::table('categories')->where('name', 'Pakaian')->value('id');
        $souvenirId = DB::table('categories')->where('name', 'Souvenir')->value('id');
        $makananId = DB::table('categories')->where('name', 'Makanan')->value('id');

        // Insert data produk
        DB::table('products')->insert([
            // Souvenir
            [
                'name' => 'Dompet Rajut',
                'price' => 10000,
                'stock' => 400,
                'category_id' => $souvenirId,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Gantungan Kunci',
                'price' => 5000,
                'stock' => 1000,
                'category_id' => $souvenirId,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Pakaian
            [
                'name' => 'Jaket Denim',
                'price' => 75000,
                'stock' => 100,
                'category_id' => $pakaianId,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Celana Mihu Mihu',
                'price' => 95000,
                'stock' => 500,
                'category_id' => $pakaianId,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Makanan
            [
                'name' => 'Risol Mayo Frozen',
                'price' => 25000,
                'stock' => 200,
                'category_id' => $makananId,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Keripik Pisang Cokelat',
                'price' => 18000,
                'stock' => 350,
                'category_id' => $makananId,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
