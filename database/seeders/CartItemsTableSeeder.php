<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CartItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('cart_items')->insert([
            ['cart_id' => 1, 'product_id' => 1, 'qty' => 1, 'created_at' => $now, 'updated_at' => $now], // Headphone
            ['cart_id' => 1, 'product_id' => 3, 'qty' => 2, 'created_at' => $now, 'updated_at' => $now], // Kaos
            ['cart_id' => 2, 'product_id' => 5, 'qty' => 3, 'created_at' => $now, 'updated_at' => $now], // Detergen
        ]);
    }
}
