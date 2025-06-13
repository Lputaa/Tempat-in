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
        Schema::create('menu_item_reservation', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
        $table->foreignId('menu_item_id')->constrained()->onDelete('cascade');
        $table->integer('quantity');
        $table->unsignedBigInteger('price'); // Harga item pada saat booking
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_reservation');
    }
};
