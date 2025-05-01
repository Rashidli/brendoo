<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HolidayBannerResource;
use App\Models\HolidayBanner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HolidayBannerController extends Controller
{
    public function index() : JsonResponse
    {

        $holiday_banner = HolidayBanner::query()->active()->first();
        return response()->json(new HolidayBannerResource($holiday_banner));

    }
}
