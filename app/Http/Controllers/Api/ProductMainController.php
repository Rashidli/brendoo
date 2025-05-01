<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductHeroResource;
use App\Http\Resources\ProductMainResource;
use App\Models\ProductMain;
use Illuminate\Http\JsonResponse;

class ProductMainController extends Controller
{
    public function index() : JsonResponse
    {

        $product_main = ProductMain::query()->active()->first();

        if(!$product_main){
            return response()->json([
                'data' => null,
                'product_main' => false
            ]);
        }

        return response()->json([
            'data' => new ProductHeroResource($product_main),
            'product_main' => true
        ]);

    }
}
