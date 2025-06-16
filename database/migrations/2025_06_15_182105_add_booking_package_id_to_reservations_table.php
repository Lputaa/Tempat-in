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
        Schema::table('reservations', function (Blueprint $table) {
            // Tambahkan kolom foreign key untuk paket, setelah restaurant_id
            $table->foreignId('booking_package_id')
                  ->nullable() // Dibuat nullable karena paket bersifat opsional
                  ->after('restaurant_id')
                  ->constrained('booking_packages')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['booking_package_id']);
            $table->dropColumn('booking_package_id');
        });
    }
};