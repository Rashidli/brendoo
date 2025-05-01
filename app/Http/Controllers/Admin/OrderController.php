<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderStatusService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function __construct(protected OrderStatusService $orderStatusService)
    {

    }
    public function index(Request $request)
    {
        $status = $request->filled('status') ? $request->status : null;
        $admin_status = $request->filled('admin_status') ? $request->admin_status : null;

        $query = Order::query()->with(['customer', 'order_items' => function ($query) use ($status,$admin_status) {
            if ($status) {
                $query->where('status', $status); // order_item statusunu filtrləyirik
            }elseif ($admin_status){
                $query->where('admin_status', $admin_status); // order_item statusunu filtrləyirik
            }
        }])->orderByDesc('id');

        // Burada Order statusunu nəzərə almırıq, yalnız OrderItem statusuna görə filtr edirik

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('customer_mail')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->customer_mail . '%');
            });
        }

        if ($request->filled('name')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $orders = $query->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }




    public function show($id)
    {

        $order = Order::query()->with('order_items')->findOrFail($id);
        $orderItems = $order->order_items()->get();
        return view('admin.orders.show', compact('orderItems','order'));

    }

//    public function updateStatus(Request $request, $id)
//    {
//        $request->validate([
//            'status' => ['required', Rule::in(array_column(OrderStatus::cases(), 'value'))],
//        ]);
//
//        $order = Order::query()->findOrFail($id);
//        $order->status = $request->status;
//        $order->save();
//
//        return redirect()->back()->with('message', 'Sifariş statusu uğurla dəyişdirildi!');
//    }

    public function cancelOrder(Request $request, $orderId)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $order = Order::findOrFail($orderId);

        if ($order->customer_id !== auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($order->status === \App\Http\Enums\OrderStatus::Cancelled->value) {
            return response()->json(['message' => 'Order already canceled'], 400);
        }

        $order->update([
            'status' => \App\Http\Enums\OrderStatus::Cancelled->value,
            'cancel_reason' => $request->reason,
        ]);

        return response()->json(['message' => 'Order canceled successfully']);
    }

    public function toggle_order_item_status($id)
    {
        $order_item = OrderItem::query()->findOrFail($id);

        $order_item->order_item_status = !$order_item->order_item_status;
        $order_item->save();

        $order = $order_item->order;
        $order->final_price = $order->order_items()
            ->where('order_item_status', true)
            ->sum('price');
        $order->save();

        return redirect()->back()->with('message', 'Status uğurla dəyişdirildi.');
    }

    public function toggleIsComplete($id)
    {

        $order = Order::findOrFail($id);

        $order->is_complete = !$order->is_complete;
        $order->save();

        return redirect()->back()->with('message', 'Status uğurla dəyişdirildi.');

    }

    public function updateStatus(Request $request, $orderItemId)
    {
//        dd($request->all());
        $request->validate([
            'status' => 'required',
        ]);

        $order = $this->orderStatusService->updateStatus($orderItemId, $request->status);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Status uğurla yeniləndi');
    }

    public function updateAdminStatus(Request $request, $orderItemId)
    {

        $request->validate([
            'admin_status' => 'required',
        ]);

        $order = OrderItem::query()->findOrFail($orderItemId);

        $order->update([
            'admin_status' => $request->admin_status
        ]);

        return redirect()->back()
            ->with('success', 'Admin status uğurla yeniləndi');
    }

}
