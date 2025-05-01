<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function index() : JsonResponse
    {
        $shops = Shop::active()->get();
        return response()->json(ShopResource::collection($shops));
    }

}
