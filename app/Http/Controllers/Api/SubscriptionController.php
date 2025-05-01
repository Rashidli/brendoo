<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function store(Request $request) : JsonResponse
    {

        $request->validate([
            'email' => 'nullable'
        ]);

        Subscription::create([
            'email' => $request->email
        ]);

        return response()->json(['message' => 'Successfully created'],201);

    }

}
