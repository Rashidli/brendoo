<?php

namespace App\Services;

use App\Mail\StockNotificationMail;
use App\Models\Customer;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;

class StockNotificationService {
    public static function notify(Customer $customer, Product $product, Option $option): void
    {
        Mail::to($customer->email)->send(new StockNotificationMail($customer, $product, $option));
    }
}
