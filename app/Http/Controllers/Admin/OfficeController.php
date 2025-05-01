<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index(Request $request)
    {
//        Log::info('sdvsd');
        $query = Order::query()->with(['customer','order_items' => function($q){
            $q->where('status', 'ordered');
        }])->orderByDesc('id');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('is_complete')) {
            $query->where('is_complete', false);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = \Carbon\Carbon::parse($request->start_date);
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();

            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if( $request->filled('customer_mail')){
            $query->whereHas('customer', function ($q)use($request){
                $q->where('email', 'like' , '%' .$request->customer_mail. '%');
            });
        }

        if ($request->filled('name')) {
            $query->whereHas('customer', function ($q) use($request){
                $q->where('name', 'like', '%'.$request->name.'%');
            });
        }

        $orders = $query->get();

        return view('admin.offices.index', compact('orders'));
    }



}
