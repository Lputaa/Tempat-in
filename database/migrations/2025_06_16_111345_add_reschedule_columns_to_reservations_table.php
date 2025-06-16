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
        $table->date('reschedule_request_date')->nullable()->after('payment_status');
        $table->time('reschedule_request_time')->nullable()->after('reschedule_request_date');
    });
}

public function down(): void
{
    Schema::table('reservations', function (Blueprint $table) {
        $table->dropColumn(['reschedule_request_date', 'reschedule_request_time']);
    });
}
};
