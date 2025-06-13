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
    Schema::create('reservations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang memesan
        $table->foreignId('restaurant_id')->constrained()->onDelete('cascade'); // Restoran mana yang dipesan
        $table->date('reservation_date');
        $table->time('reservation_time');
        $table->unsignedTinyInteger('number_of_guests');
        $table->string('status')->default('pending'); // pending, confirmed, cancelled
        $table->text('notes')->nullable(); // Catatan tambahan dari pengguna
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
