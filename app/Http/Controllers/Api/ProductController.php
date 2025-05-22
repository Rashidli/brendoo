<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeProductResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SearchProductsResource;
use App\Models\Product;
use App\Models\RecentlyViewedProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request) :JsonResponse
    {

        $query = Product::query()
            ->with(['filters.options', 'category', 'sub_category', 'sliders', 'brand'])
            ->where('is_active', true);

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

        if ($request->filled('discount') && $request->boolean('discount') === true) {
            $query->where(function ($q) {
                $q->whereNotNull('discount')->where('discount', '!=', 0);
            });
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
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);

    }

    public function search(Request $request)
    {

        $query = DB::table('products')
            ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->where('products.is_active', true)
            ->where('product_translations.locale', app()->getLocale())
            ->select('products.id','products.price','products.image','product_translations.slug', 'product_translations.title')
            ->orderByDesc('products.id');

        if ($request->has('search') && $request->search !== '') {
            $query->where('product_translations.title', 'like', '%'. $request->search . '%');
        }

        $products = $query->paginate(20);

        return response()->json(SearchProductsResource::collection($products));

    }

    public function productSingle($slug) : JsonResponse
    {

        $product = Product::query()->with(['comments' => function ($q) {
            $q->with('customer')->where('is_accept', true);
            },'filters.options',
                'category','sub_category','sliders', 'filters']
        )
            ->whereTranslation('slug', $slug)->first();
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
