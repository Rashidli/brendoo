<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendBulkNotificationJob;
use App\Models\Customer;
use App\Models\Notice;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendBulkNotification(Request $request)
    {

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string|max:1000',
            ]);

            Customer::query()
                ->whereNull('email_verification_token')
                ->where('is_blocked', false)
                ->chunk(100, function ($customers) use ($request) {
                    foreach ($customers as $customer) {
                        Notice::create([
                            'title' => $request->title,
                            'body' => $request->body,
                            'customer_id' => $customer->id
                        ]);
                    }
                });

            return redirect()->route('customers.index')->with('message', 'Bildirişlər göndərildi.');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

    }

    public function sendSingleNotification(Request $request)
    {

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string|max:1000',
            ]);

            Notice::create([
                'title' => $request->title,
                'body' => $request->body,
                'customer_id' => $request->customer_id
            ]);

            return redirect()->route('customers.index')->with('message', 'Bildiriş göndərildi.');
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

}
