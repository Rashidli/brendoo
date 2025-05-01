<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopLineResource;
use App\Models\TopLine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TopLineController extends Controller
{
    public function index() : JsonResponse
    {

        $top_line = TopLine::query()->active()->first();

        if(!$top_line){
            return response()->json([
                'data' => null,
                'top_line' => false
            ]);
        }

        return response()->json([
            'data' => new TopLineResource($top_line),
            'top_line' => true
        ]);

    }
}
