<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('categories')->insert([
            ['name' => 'Pakaian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Souvenir',    'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Makanan', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
