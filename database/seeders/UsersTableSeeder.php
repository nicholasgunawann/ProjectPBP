<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin', 
        ]);

        User::create([
            'name' => 'Siti Maemunah',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}