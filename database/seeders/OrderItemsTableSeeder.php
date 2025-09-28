<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $prices = DB::table('products')
            ->pluck('price', 'id'); 

        $oi = [
            [
                'order_id' => 1,
                'product_id' => 1,
                'price' => $prices[1],
                'qty' => 1,
                'subtotal' => $prices[1] * 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'order_id' => 1,
                'product_id' => 3,
                'price' => $prices[3],
                'qty' => 2,
                'subtotal' => $prices[3] * 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'order_id' => 2,
                'product_id' => 5,
                'price' => $prices[5],
                'qty' => 2,
                'subtotal' => $prices[5] * 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'order_id' => 2,
                'product_id' => 4,
                'price' => $prices[4],
                'qty' => 1,
                'subtotal' => $prices[4] * 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('order_items')->insert($oi);

        $totals = DB::table('order_items')
            ->select('order_id', DB::raw('SUM(subtotal) as total'))
            ->groupBy('order_id')
            ->pluck('total', 'order_id'); 

        foreach ($totals as $orderId => $total) {
            DB::table('orders')->where('id', $orderId)->update([
                'total' => $total, 
                'updated_at' => $now,
            ]);
        }
    }
}
