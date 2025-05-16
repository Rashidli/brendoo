<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Enums\AdminOrderStatus;
use App\Http\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function createPayment(Request $request)
    {

        $paymentData = $request->validate([
            'final_price' => 'required|min:0'
        ]);

        $response = $this->paymentService->createPayment($paymentData);

        Payment::create([
            'order_id' => null,
            'customer_id' => auth()->user()->id,
            'operation_id' => $response['Data']['operationId'],
            'amount' => $response['Data']['amount'],
            'status' => $response['Data']['status'],
            'payment_method' => null,
            'meta' => json_encode($response['Data']),
        ]);

        $link = $response['Data']['paymentLink'];
        $operationId = $response['Data']['operationId'];

        return response()->json([
            'payment_link' => $link,
            'operation_id' => $operationId,
        ]);

    }

    public function checkOrderPayment(Request $request)
    {

        $request->validate([
            'operation_id' => 'required',
            'order_id' => 'required'
        ]);

        $response = $this->paymentService->checkPaymentStatus($request->operation_id);

        $status = $response['Data']['Operation'][0]['status'];

        $payment = Payment::query()->where('operation_id', $request->operation_id)->first();

        $payment->update([
            'status' => $status,
            'order_id' => $request->order_id
        ]);

        if ($response['Data']['Operation'][0]['status'] == 'APPROVED'){
            $order = Order::query()->with('order_items')->where('id', $request->oder_id)->get();

            foreach ($order->order_items as $order_item){
                $order_item->update([
                    'status' => OrderStatus::Ordered,
                    'admin_status' => AdminOrderStatus::AdminPaid,
                ]);
            }
        }

        return response()->json([
            'success' => true
        ]);

    }

}
