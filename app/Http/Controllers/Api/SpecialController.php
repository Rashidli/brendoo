<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialResource;
use App\Models\Special;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpecialController extends Controller
{
    public function index() : JsonResponse
    {
        $special = Special::query()->active()->first();
        if(!$special){
            return response()->json([
                'data' => null,
                'is_special' => false
            ]);
        }
        return response()->json([
            'data' => new SpecialResource($special),
            'is_special' => true
        ]);
    }
}
