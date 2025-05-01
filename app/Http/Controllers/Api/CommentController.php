<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'comment' => 'nullable|string|max:1000',
            'star' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        Comment::create([
            'product_id' => $request->product_id,
            'comment' => $request->comment ?? null,
            'customer_id' => auth()->user()->id,
            'star' => $request->star,
        ]);

        return response()->json(['message' => 'Rəyiniz uğurla göndərildi'], 201);
    }
}
