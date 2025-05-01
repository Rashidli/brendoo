<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SocialResource;
use App\Models\Social;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index() : JsonResponse
    {
        $socials = Social::query()->active()->get();
        return response()->json(SocialResource::collection($socials));
    }
}
