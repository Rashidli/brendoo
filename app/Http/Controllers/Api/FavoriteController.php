<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index() : JsonResponse
    {

        try {
            $favorites = Favorite::query()->where('customer_id', auth()->user()->id)->with('product')->get();
            return response()->json(FavoriteResource::collection($favorites));
        }catch (\Exception  $exception){
            return response()->json($exception->getMessage());
        }
    }

    public function toggleFavorite(Request $request) : JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $favorite = Favorite::where('customer_id', auth()->user()->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Favoritdən silindi']);
        } else {
            $newFavorite = Favorite::create([
                'customer_id' => auth()->user()->id,
                'product_id' => $request->product_id,
            ]);
            return response()->json(['message' => 'Favoritə əlavə edildi', 'favorite' => new FavoriteResource($newFavorite)]);
        }
    }
}
