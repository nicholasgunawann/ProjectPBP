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

        DB::table('products')->insert([
            ['name' => 'Headphone Bluetooth', 'price' => 350000, 'stock' => 20, 'category_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Keyboard Mekanik',     'price' => 550000, 'stock' => 15, 'category_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kaos Polos',           'price' => 80000,  'stock' => 100,'category_id' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kemeja Lengan Panjang','price' => 175000, 'stock' => 40, 'category_id' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Detergen 2kg',         'price' => 45000,  'stock' => 60, 'category_id' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Pewangi Pakaian',      'price' => 30000,  'stock' => 80, 'category_id' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
