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
    Schema::create('tables', function (Blueprint $table) {
        $table->id();
        $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
        $table->string('name'); // Contoh: "Meja 1", "Sofa Pojok", "Outdoor A"
        $table->unsignedTinyInteger('capacity'); // Contoh: 4 (untuk 4 orang)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
