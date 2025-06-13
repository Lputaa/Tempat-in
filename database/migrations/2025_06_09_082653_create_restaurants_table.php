<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            // Foreign key untuk mengaitkan dengan user admin
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->string('address');
            $table->string('phone_number');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->string('profile_image_path')->nullable(); // Path untuk foto restoran
            $table->boolean('is_active')->default(true); // Status aktif/non-aktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};