<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\SettlementResource;
use App\Models\City;
use App\Models\District;
use App\Models\Settlement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index() : JsonResponse
    {
        $cities = City::all();
        return response()->json(CityResource::collection($cities));
    }

    public function getDistricts($cityId) : JsonResponse
    {
        $districts = District::query()->where('city_id', $cityId)->get();
        return response()->json(DistrictResource::collection($districts));
    }

    public function getSettlements($districtId) : JsonResponse
    {
        $settlements = Settlement::query()->where('district_id', $districtId)->get();
        return response()->json(SettlementResource::collection($settlements));
    }
}
