<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CatalogCategoryResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\HomeCategoryResource;
use App\Http\Resources\SubCategoryResource;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(): JsonResponse
    {

        $categories = Category::with('subCategories', 'filters.options')->get();
        return response()->json(CategoryResource::collection($categories));

    }

    public function catalog_categories(): JsonResponse
    {

        $categories = Category::with('subCategories.third_categories')->get();
        return response()->json(CatalogCategoryResource::collection($categories));

    }

    public function sub_categories(): JsonResponse
    {

        $sub_categories = SubCategory::all();
        return response()->json(SubCategoryResource::collection($sub_categories));

    }

    public function home_categories(): JsonResponse
    {

        $categories = Category::query()->where('is_home', true)
            ->with('products', function ($query) {
                $query->orderByDesc('created_at')->take(15);
            })
            ->get();
        return response()->json(HomeCategoryResource::collection($categories));

    }

}
