<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactItemResource;
use App\Models\ContactItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactItemController extends Controller
{
    public function index() : JsonResponse
    {
        $contact_items = ContactItem::query()->active()->get();
        return response()->json(ContactItemResource::collection($contact_items));
    }
}
