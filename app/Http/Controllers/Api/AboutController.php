<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Models\About;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AboutController extends Controller
{

    public function index() : JsonResponse
    {
        $about = About::query()->active()->first();
        return response()->json(new AboutResource($about));
    }

}
