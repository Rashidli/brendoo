<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoticeResource;
use App\Models\Customer;
use App\Models\Notice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index() : JsonResponse
    {
        $customer = Customer::query()->findOrFail(auth()->user()->id);

        $notices = Notice::query()->orderByDesc('id')->where('customer_id', $customer->id)->get();

        return response()->json(NoticeResource::collection($notices));
    }

    public function update(Request $request)
    {
        $notification = Notice::query()->findOrFail($request->notification_id);
        $notification->is_read = $request->is_read;
        $notification->save();

        return response()->json(['message' => 'Notification updated']);
    }
}
