<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockNotification;
use Illuminate\Http\Request;

class StockNotificationController extends Controller
{
    public function index()
    {
        $stock_notifications = StockNotification::query()
            ->with('product','customer','option')
            ->paginate(20);
        return view('admin.stock_notifications.index', compact('stock_notifications'));
    }
}
