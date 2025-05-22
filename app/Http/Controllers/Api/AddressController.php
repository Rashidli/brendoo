<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    public function index() : JsonResponse
    {
        $customer = Customer::query()->findOrFail(auth()->user()->id);
        $address = $customer->address;
        return response()->json(new AddressResource($address));
    }

    public function storeOrUpdate(Request $request) : JsonResponse
    {

        $request->validate([
            'address' => 'required|max:255',
            'additional_info' => 'nullable',
            'region_id' => 'nullable',
            'city_id' => 'nullable',
        ]);

        $customer = Customer::query()->findOrFail(auth()->user()->id);

        $address = $customer->address()->updateOrCreate(
            [],
            [
                'address' => $request->address,
                'additional_info' => $request->additional_info,
                'region_id' => $request->additional_info,
                'city_id' => $request->additional_info,
            ]
        );

        return response()->json(new AddressResource($address));

    }


}
