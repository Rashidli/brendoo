<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReasonResource;
use App\Models\Reason;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    public function index() : JsonResponse
    {
        $reasons = Reason::query()->active()->get();
        return response()->json(ReasonResource::collection($reasons));
    }
}
