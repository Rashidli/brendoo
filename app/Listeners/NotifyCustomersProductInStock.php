<?php

namespace App\Listeners;

use App\Events\ProductBackInStock;
use App\Mail\ProductInStockMail;
use App\Models\StockNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyCustomersProductInStock
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductBackInStock $event): void
    {
        $product = $event->product;

        $notifications = StockNotification::where('product_id', $product->id)
            ->where('notified', false)
            ->get();

        foreach ($notifications as $notification) {
            $customer = $notification->customer;

            Mail::to($customer->email)->send(new ProductInStockMail($product));

            $notification->update(['notified' => true]);
        }
    }
}
