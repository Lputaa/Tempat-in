<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_packages', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke restoran mana paket ini dimiliki
        $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
        $table->string('name'); // Contoh: "Booking Standar", "Ruang VIP"
        $table->text('description')->nullable(); // Deskripsi singkat tentang paket
        $table->unsignedBigInteger('price'); // Harga dalam satuan terkecil (misal: 50000 untuk Rp 50.000)
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_packages');
    }
};
