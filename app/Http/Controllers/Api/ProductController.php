<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeProductResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\RecentlyViewedProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) :JsonResponse
    {

        try {
            $query = Product::query()
                ->with(['filters.options', 'category', 'sub_category', 'sliders', 'brand'])
                ->withCount('comments')
                ->where('is_active', true)
                ->where('status', '!=', 'olmayacaq');

            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->has('sub_category_id')) {
                $query->where('sub_category_id', $request->sub_category_id);
            }

            if ($request->has('third_category_id')) {
                $query->where('third_category_id', $request->third_category_id);
            }

            if($request->has('min_price') && $request->has('max_price')){
                $query->whereBetween('price',[$request->min_price, $request->max_price]);
            }

            if($request->has('brand_id')){
                $query->where('brand_id', $request->brand_id);
            }

            if ($request->filled('is_discount') && $request->boolean('is_discount')) {
                $query->whereNotNull('discount');
            }

            if ($request->filled('is_season') && $request->boolean('is_season')) {
                $query->where('is_season',true);
            }

            if ($request->filled('is_popular') && $request->boolean('is_popular')) {
                $query->where('is_popular',true);
            }

            if($request->has('search')){
                $query->whereTranslationLike('title', '%' . $request->search . '%');
            }

            $optionIds = $request->option_ids;
            if($optionIds){
                $query->whereHas('options', function ($query) use ($optionIds) {
                    $query->whereIn('options.id', $optionIds);
                });
            }

            if ($request->has('sort')) {
                switch ($request->sort) {
                    case 'A-Z':
                        $query->orderByTranslation('title','ASC');
                        break;
                    case 'Z-A':
                        $query->orderByTranslation('title','DESC');
                        break;
                    case 'expensive-cheap':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'cheap-expensive':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'old-new':
                        $query->orderBy('created_at', 'asc');
                        break;
                    case 'new-old':
                        $query->orderBy('created_at', 'desc');
                        break;
                    default:
                        break;
                }
            }

            $products = $query->orderByDesc('id')->paginate(16);

            return response()->json([
                'data' => HomeProductResource::collection($products),
                'count' => $products->count(),
                'meta' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ],
            ]);

        }catch (\Exception $exception){

            return response()->json($exception->getMessage());

        }
    }

    public function productSingle($slug) : JsonResponse
    {
        $product = Product::query()->with(
            'filters.options','comments.customer',
            'category','sub_category','sliders', 'filters'
        )
            ->whereHas('translation', function ($q) use($slug){
                $q->where('slug', $slug);
            })->first();
        return response()->json(new ProductResource($product));
    }

    public function product($id): JsonResponse
    {
        try {
            $product = Product::with(
                'filters.options',
                'comments.customer',
                'category',
                'sub_category',
                'sliders'
            )->findOrFail($id);

            return response()->json(new ProductResource($product));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found.',
                'status' => 404
            ], 404);
        }
    }

    public function getProducts(Request $request) : JsonResponse
    {
        $product_ids = $request->product_ids ?? [];
        $products = Product::query()->whereIn('id', $product_ids)->get();

        return response()->json(ProductResource::collection($products));

    }


    public function trackProductView(Request $request): JsonResponse
    {
        $productId = $request->product_id;

        if (!auth()->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId = auth()->user()->id;

        $existingView = RecentlyViewedProduct::query()->where('customer_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if (!$existingView) {
            RecentlyViewedProduct::create([
                'customer_id' => $userId,
                'product_id' => $productId
            ]);
        }

        // Yalnız son 5 baxılan məhsulu saxla
//        RecentlyViewedProduct::query()->where('customer_id', $userId)
//            ->orderBy('created_at', 'desc')
//            ->skip(5)
//            ->take(PHP_INT_MAX)
//            ->delete();

        return response()->json(['message' => 'Viewed products updated']);
    }

    public function getRecentlyViewedProducts(): JsonResponse
    {
        if (!auth()->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId = auth()->user()->id;

        $productIds = RecentlyViewedProduct::where('customer_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->pluck('product_id');

        if ($productIds->isEmpty()) {
            return response()->json([]);
        }

        $products = Product::query()->whereIn('id', $productIds)
            ->orderByRaw("FIELD(id, " . implode(',', $productIds->toArray()) . ")")
            ->get();


        return response()->json(HomeProductResource::collection($products));
    }


}
