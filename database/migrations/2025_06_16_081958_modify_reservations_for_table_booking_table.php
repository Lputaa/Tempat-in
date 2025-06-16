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
        // Hapus kolom lama
        $table->dropColumn('number_of_guests');

        // Tambahkan kolom baru untuk meja
        $table->foreignId('table_id')->nullable()->after('restaurant_id')->constrained()->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('reservations', function (Blueprint $table) {
        $table->dropForeign(['table_id']);
        $table->dropColumn('table_id');
        $table->unsignedTinyInteger('number_of_guests')->after('restaurant_id');
    });
}
};
