<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoginBannerResource;
use App\Models\LoginBanner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginBannerController extends Controller
{
    public function index() : JsonResponse
    {
        $login_banner = LoginBanner::query()->active()->first();
        return response()->json(new LoginBannerResource($login_banner));
    }
}
