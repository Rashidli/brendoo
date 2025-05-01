<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RuleResource;
use App\Models\Delivery;
use App\Models\Refund;
use App\Models\Rule;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{

    // Çatdırılma şərtləri
    public function index()
    {
        $delivery = Delivery::active()->first();
        return response()->json(new RuleResource($delivery));
    }


    // Məxfilik siyasəti
    public function rule()
    {
        $delivery = Rule::active()->first();
        return response()->json(new RuleResource($delivery));
    }


    // Qaytarılma şərtləri
    public function refund()
    {
        $delivery = Refund::active()->first();
        return response()->json(new RuleResource($delivery));
    }

}
