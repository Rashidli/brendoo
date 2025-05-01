<?php

namespace App\Utils;
use App\Models\Customer;
use Illuminate\Support\Facades\Http;

class FirebaseNotification
{
    function sendFirebaseNotification($customerId, $title, $body)
    {
        $customer = Customer::query()->find($customerId);
        if (!$customer) {
            return false;
        }

        $fcmTokens = $customer->fcmTokens()->pluck('fcm_token')->toArray();

        if (empty($fcmTokens)) {
            return false;
        }

        $firebaseServerKey = env('FIREBASE_SERVER_KEY');

        $payload = [
            'registration_ids' => $fcmTokens, // Send to multiple devices
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
            ],
            'data' => [
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                'type' => 'order_update',
            ],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $firebaseServerKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', $payload);

        return $response->json();
    }
}
