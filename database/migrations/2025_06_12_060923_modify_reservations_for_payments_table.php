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
        // Kolom-kolom baru untuk menyimpan ringkasan pesanan
        $table->unsignedBigInteger('subtotal')->default(0)->after('number_of_guests');
        $table->unsignedBigInteger('service_fee')->default(0)->after('subtotal');
        $table->unsignedBigInteger('total_price')->default(0)->after('service_fee');
        $table->unsignedBigInteger('down_payment_amount')->default(0)->after('total_price');
        $table->string('payment_status')->default('pending')->after('down_payment_amount'); // pending, paid, expired
        $table->string('midtrans_order_id')->nullable()->after('payment_status');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Logika untuk rollback jika diperlukan
            $table->dropColumn([
                'subtotal',
                'service_fee',
                'total_price',
                'down_payment_amount',
                'payment_status',
                'midtrans_order_id',
            ]);
        });
    }
};
