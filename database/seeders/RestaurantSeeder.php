<?php

// database/seeders/RestaurantSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Restaurant;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cari pengguna pertama yang memiliki peran 'admin'
        //    Pastikan Anda sudah punya user dengan peran 'admin' di database.
        $adminUser = User::where('role', 'admin')->first();

        // 2. Jika admin ditemukan, buatkan satu restoran untuknya
        if ($adminUser) {
            // Pastikan admin tersebut belum punya restoran
            if (!$adminUser->restaurant) {
                Restaurant::factory()->create([
                    'user_id' => $adminUser->id,
                ]);
            }
        } else {
            // Opsional: Beri peringatan jika tidak ada user admin
            $this->command->warn('Tidak ada pengguna dengan peran "admin" ditemukan. Seeder restoran dilewati.');
        }
    }
}