<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Set konfigurasi Midtrans
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$serverKey = config('services.midtrans.server_key');

        try {
            $notification = new Notification();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid notification'], 400);
        }

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;
        $fraudStatus = $notification->fraud_status;

        $reservation = Reservation::where('midtrans_order_id', $orderId)->first();

        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }

        // Logika untuk update status pembayaran
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            if ($fraudStatus == 'accept') {
                $reservation->update(['payment_status' => 'paid']);
            }
        } else if ($transactionStatus == 'expire') {
            $reservation->update(['payment_status' => 'expired']);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny') {
            $reservation->update(['payment_status' => 'cancelled']);
        }

        return response()->json(['status' => 'ok']);
    }
}