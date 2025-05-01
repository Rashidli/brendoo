<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeoResource;
use App\Models\Single;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index() : JsonResponse
    {
        $singles =  Single::all();
        return response()->json(SeoResource::collection($singles));
    }
}
