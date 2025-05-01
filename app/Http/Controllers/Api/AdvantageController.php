<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvantageResource;
use App\Models\Advantage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdvantageController extends Controller
{
    public function index() : JsonResponse
    {
        $advantages = Advantage::active()->get();
        return response()->json(AdvantageResource::collection($advantages));
    }
}
