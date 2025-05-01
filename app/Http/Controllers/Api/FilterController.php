<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FilterResource;
use App\Models\Filter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function index() : JsonResponse
    {
        $filters = Filter::query()->with('options')->get();
        return response()->json(FilterResource::collection($filters));
    }
}
