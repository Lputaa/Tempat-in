<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'user_id' akan kita tentukan secara manual di Seeder
            'name' => $this->faker->company, // Contoh: "Sunda Rasa Group"
            'description' => $this->faker->paragraph(3),
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'opening_time' => '09:00:00',
            'closing_time' => '22:00:00',
            'profile_image_path' => null, // Biarkan null untuk awal
            'is_active' => true,
        ];
    }
}
