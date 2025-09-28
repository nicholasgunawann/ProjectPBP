<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrdersTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('orders')->insert([
            [
                'user_id' => 2, 
                'total' => 0,   
                'status' => 'diproses',
                'address_text' => 'Jl. Melati No. 10, Jakarta',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 3, 
                'total' => 0,
                'status' => 'diproses',
                'address_text' => 'Jl. Kenanga No. 5, Bandung',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
