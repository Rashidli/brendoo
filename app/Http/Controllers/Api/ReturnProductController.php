<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReturnProductResource;
use App\Models\OrderItem;
use App\Models\ReturnProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReturnProductController extends Controller
{


    public function index(): JsonResponse
    {

        $returns = ReturnProduct::query()
            ->where('customer_id', auth()->user()->id)
            ->with('orderItem.product')
            ->get();

        return response()->json(ReturnProductResource::collection($returns));

    }



    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'products' => 'required|array',
                'quantities' => 'required|array',
                'reason' => 'nullable|string',
            ]);

            $returnProducts = [];

            foreach ($request->products as $order_item_id) {
                $orderItem = OrderItem::query()->findOrFail($order_item_id);

                if ($orderItem->returnProduct) {
                    continue;
                }

                $returnProducts[] = ReturnProduct::query()->create([
                    'order_item_id' => $order_item_id,
                    'customer_id' => auth()->user()->id,
                    'quantity' => $request->quantities[$order_item_id],
                    'status' => 'pending',
                    'reason' => $request->reason,
                ]);
            }

            return response()->json([
                'message' => 'Geri qaytarma tələbi uğurla göndərildi!',
                'data' => $returnProducts
            ], 201);
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }

}
