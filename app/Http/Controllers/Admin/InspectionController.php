<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Inspection;
use App\Models\SubCategory;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 20);

        $products = $this->productService
            ->filterTitle($request->title)
            ->filterCode($request->code)
            ->filterIsActive(true)
            ->filterLowStock($request->stock)
            ->filterCategory($request->category)
            ->filterSubcategory($request->subcategory)
            ->filterBrand($request->brand)
            ->filterUser($request->user_id)
            ->filterStartDate($request->start_act)
            ->filterEndDate($request->end_act)
            ->getQuery()
            ->orderByDesc('id')
            ->paginate($limit)
            ->withQueryString();

        $categories = Category::all();
        $subcategories = SubCategory::all();
        $brands = Brand::all();
        $users = User::all();

//        dd($products);
        return view('admin.inspections.index', compact(
            'products',
            'categories',
            'subcategories',
            'brands',
            'users'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void {}

    /**
     * Display the specified resource.
     */
    public function show(Inspection $inspection): void {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inspection $inspection): void {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inspection $inspection): void {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspection $inspection): void {}
}
