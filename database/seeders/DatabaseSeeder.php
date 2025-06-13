<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
    {
        $this->call([
            UserSeeder::class,       // <-- PANGGIL INI DULU untuk membuat user admin
            RestaurantSeeder::class, // <-- BARU PANGGIL INI untuk membuat restoran milik admin
        ]);
    }
}