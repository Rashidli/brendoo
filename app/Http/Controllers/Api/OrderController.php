<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Enums\AdminOrderStatus;
use App\Http\Enums\OrderStatus;
use App\Http\Resources\OrderResource;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Log;

class OrderController extends Controller
{
    private function calculateDiscount(Coupon $coupon, float $totalPrice): float
    {
        if ('percentage' === $coupon->type) {
            return $totalPrice * ($coupon->discount / 100);
        }

        return round($coupon->discount, 2);
    }

    public function storeOrder(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $customer    = Customer::query()->findOrFail(auth()->user()->id);
            $basketItems = $customer->basketItems()->with('options')->get();

            if ($basketItems->isEmpty()) {
                return response()->json(['message' => 'Basket is empty.'], 400);
            }

            $validator = Validator::make($request->all(), [
                'address' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all(),
                ], 422);
            }

            $couponData = null;

            $discountAmount = $request->discount;

            $finalPrice = $request->final_price;

            $order = $customer->orders()->create([
                'status'       => OrderStatus::Pending,
                'order_number' => mb_strtoupper(uniqid('ORDER_')),
                'is_deliver'   => $request->input('is_deliver', false),
                'shop'         => $request->input('shop'),
                'payment_type' => $request->input('payment_type', 'cash'),
                'total_price'  => $request->total_price,
                'discount'     => $discountAmount,
                //                'delivered_price' => $request->delivered_price,
                'final_price'     => $finalPrice,
                'address'         => $request->input('address'),
                'additional_info' => $request->input('additional_info'),
                'region'        => $request->input('region'),
                'city'            => $request->input('city'),
                'regionId'        => $request->input('regionId'),
                'cityId'            => $request->input('cityId'),
            ]);

            foreach ($basketItems as $basketItem) {
                $orderItem = $order->order_items()->create([
                    'status'       => OrderStatus::Pending,
                    'admin_status' => AdminOrderStatus::Pending,
                    'product_id'   => $basketItem->product_id,
                    'quantity'     => $basketItem->quantity,
                    'price'        => $basketItem->price,
                    'customer_id'  => auth()->user()->id,
                ]);

                foreach ($basketItem->options as $option) {
                    $orderItem->options()->create([
                        'filter_id' => $option->filter_id,
                        'option_id' => $option->option_id,
                    ]);
                }
            }

            if ($couponData) {
                $order->coupons()->attach($couponData['coupon']->id);
            }

            $customer->basketItems()->delete();

            DB::commit();

            return response()->json(['order' => new OrderResource($order)], 201);
        } catch (Exception $exception) {
            DB::rollBack();

            Log::error('Order creation failed', ['error' => $exception->getMessage()]);

            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function applyCoupon(Request $request): JsonResponse
    {
        $couponCode = $request->coupon_code;
        $totalPrice = $request->total_price;
        $coupon     = Coupon::query()->where('code', $couponCode)->first();
        $customer   = Customer::query()->findOrFail(auth()->user()->id);

        if ( ! $coupon || ! $coupon->isValid()) {
            return response()->json(['error' => 'Invalid or expired coupon code.'], 422);
        }

        if ($customer->coupons->contains($coupon->id)) {
            return response()->json(['error' => 'You have already used this coupon.'], 422);
        }

        $customer->coupons()->attach($coupon->id);

        $discountAmount = round($totalPrice - $this->calculateDiscount($coupon, $totalPrice), 2);

        return response()->json(['coupon' => $coupon, 'discounted_total_price' => $discountAmount]);
    }

    public function getOrders(Request $request): JsonResponse
    {
        $status = $request->status;

        $customer = Customer::query()
            ->with(['orders' => function ($query) use ($status): void {
                $query->with(['order_items' => function ($query) use ($status): void {
                    if ($status) {
                        $query->where('status', $status);
                    }
                }])->withCount('order_items');
            }])
            ->findOrFail(auth()->user()->id);

        return response()->json(OrderResource::collection($customer->orders));
    }

    public function getOrderItem($id): JsonResponse
    {
        try {
            $order = Order::query()->with('order_items')->withCount('order_items')->findOrFail($id);

            return response()->json(new OrderResource($order));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Order not found.',
                'status'  => 404,
            ], 404);
        }
    }

    public function cancelOrder(Request $request): JsonResponse
    {
        $request->validate([
            'order_id'      => 'required|exists:orders,id',
            'cancel_reason' => 'nullable|string|max:255',
            'cancel_note'   => 'nullable|string',
        ]);

        $order = Order::find($request->order_id);

        if ('cancelled' === $order->status) {
            return response()->json(['message' => 'Order is already canceled.'], 400);
        }

        $order->status        = 'cancelled'; // Assuming this is the cancellation status
        $order->cancel_reason = $request->cancel_reason;
        $order->cancel_note   = $request->cancel_note;
        $order->save();

        return response()->json(['message' => 'Order canceled successfully.']);
    }

    public function changeOrderAddress(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_id'        => 'required|exists:orders,id',
            'address'         => 'required|string',
            'additional_info' => 'nullable|string',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        $order->address = $validated['address'];

        if (isset($validated['additional_info'])) {
            $order->additional_info = $validated['additional_info'];
        }

        $order->save();

        return response()->json([
            'message' => 'Address changed successfully.',
            'order'   => $order->only(['id', 'address', 'additional_info']),
        ]);
    }
}
