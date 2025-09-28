<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('users')->insert([
            [
                'name' => 'Admin Toko',
                'email' => 'admin@toko.test',
                'email_verified_at' => $now,
                'password' => Hash::make('password'),
                'role' => 'admin',
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Budi',
                'email' => 'budi@toko.test',
                'email_verified_at' => null,
                'password' => Hash::make('password'),
                'role' => 'pengguna',
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Siti',
                'email' => 'siti@toko.test',
                'email_verified_at' => null,
                'password' => Hash::make('password'),
                'role' => 'pengguna',
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
