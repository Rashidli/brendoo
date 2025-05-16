<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Base query with all filters
        $query = OrderItem::query()
            ->with(['order.customer', 'product'])
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('admin_status'), function ($q) use ($request) {
                $q->where('admin_status', $request->admin_status);
            })
            ->whereHas('order', function ($q) use ($request) {
                if ($request->filled('start_date')) {
                    $q->whereDate('created_at', '>=', $request->start_date);
                }
                if ($request->filled('end_date')) {
                    $q->whereDate('created_at', '<=', $request->end_date);
                }
                if ($request->filled('customer_id')) {
                    $q->where('customer_id', $request->customer_id);
                }
                if ($request->filled('customer_mail')) {
                    $q->whereHas('customer', fn ($subQ) => $subQ->where('email', 'like', '%' . $request->customer_mail . '%'));
                }
                if ($request->filled('name')) {
                    $q->whereHas('customer', fn ($subQ) => $subQ->where('name', 'like', '%' . $request->name . '%'));
                }
            });

        // Clone the query for statistics before applying pagination
        $statsQuery = clone $query;

        // Calculate statistics
        $totalRevenue = $statsQuery->sum(DB::raw('price * quantity'));
        $totalItems = $statsQuery->count();
        $totalQuantity = $statsQuery->sum('quantity');

        // Apply pagination to the original query
        $orderItems = $query->latest()->paginate(20)->withQueryString();

        return view('admin.reports.index', compact(
            'orderItems',
            'totalRevenue',
            'totalItems',
            'totalQuantity'
        ));
    }


}
