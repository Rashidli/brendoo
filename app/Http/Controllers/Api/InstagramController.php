<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstagramResource;
use App\Models\Instagram;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstagramController extends Controller
{
    public function index() : JsonResponse
    {
        $instagrams = Instagram::query()->orderByDesc('id')->get();
        return response()->json(InstagramResource::collection($instagrams));
    }
}
