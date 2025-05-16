<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Option;
use App\Models\Product;
use App\Models\StockNotification;
use Illuminate\Http\Request;
use App\Services\StockNotificationService;
use Illuminate\Support\Facades\DB;

class StockNotificationController extends Controller
{

    public function index()
    {
        $stock_notifications = StockNotification::query()
            ->with('product','customer','option')
            ->paginate(20);
        return view('admin.stock_notifications.index', compact('stock_notifications'));
    }


    public function sendEmailStockNotifications(Request $request)
    {

        $customer = Customer::query()->findOrFail($request->customer_id);
        $product = Product::query()->findOrFail($request->product_id);
        $option = Option::query()->with('filter')->findOrFail($request->option_id);

        StockNotificationService::notify($customer, $product, $option);
        DB::table('stock_notifications')->where('id', $request->stock_notification_id)->update([
            'notified' => true
        ]);
        return redirect()->back()->with('message','Mesajınız uğurla göndərildi.');
    }


}
