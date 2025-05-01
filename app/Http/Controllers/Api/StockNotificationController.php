<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockNotification;
use Illuminate\Http\Request;

class StockNotificationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'option_id' => 'required|exists:options,id',
        ]);

        StockNotification::create([
            'product_id' => $validated['product_id'],
            'option_id' => $validated['option_id'],
            'customer_id' => auth()->user() ? auth()->user()->id : null,
        ]);

        return response()->json(['message' => 'You will be notified when the product is back in stock.']);
    }
}
