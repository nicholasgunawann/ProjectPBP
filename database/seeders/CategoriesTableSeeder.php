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
            ['name' => 'Elektronik', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Fashion',    'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kebutuhan Rumah', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
