<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ThirdCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-banners|create-banners|edit-banners|delete-banners', ['only' => ['index','show']]);
        $this->middleware('permission:create-banners', ['only' => ['create','store']]);
        $this->middleware('permission:edit-banners', ['only' => ['edit']]);
        $this->middleware('permission:delete-banners', ['only' => ['destroy']]);
    }

    public function index()
    {

        $banners = Banner::paginate(10);
        return view('admin.banners.index', compact('banners'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $thirdCategories = ThirdCategory::all();
        $brands = Brand::all();
        return view('admin.banners.create',
            compact('categories','subCategories','thirdCategories','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'en_description'=>'nullable',
            'ru_description'=>'nullable',
            'image'=>'required',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }

        $filterConditions = collect($request->only([
            'category_id',
            'sub_category_id',
            'third_category_id',
            'min_price',
            'max_price',
            'brand_id',
        ]))
            ->filter()
            ->toArray();

        if ($request->has('is_discount') && $request->boolean('is_discount')) {
            $filterConditions['is_discount'] = 1;
        }

        if ($request->has('is_season') && $request->boolean('is_season')) {
            $filterConditions['is_season'] = 1;
        }

        if ($request->has('is_popular') && $request->boolean('is_popular')) {
            $filterConditions['is_popular'] = 1;
        }


        Banner::create([
            'image'=>  $filename,
            'filter_conditions' => $filterConditions,
            'en'=>[
                'title'=>$request->en_title,
                'description'=>$request->en_description,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'description'=>$request->ru_description,
            ]
        ]);

        return redirect()->route('banners.index')->with('message','Banner added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {

        $categories = Category::all();
        $subCategories = SubCategory::all();
        $thirdCategories = ThirdCategory::all();
        $brands = Brand::all();
        return view('admin.banners.edit', compact('banner','categories','subCategories','thirdCategories','brands'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'en_description'=>'nullable',
            'ru_description'=>'nullable',
        ]);

        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $banner->image = $filename;

        }

        $filterConditions = collect($request->only([
            'category_id',
            'sub_category_id',
            'third_category_id',
            'min_price',
            'max_price',
            'brand_id',
        ]))
            ->filter()
            ->toArray();

        if ($request->has('is_discount') && $request->boolean('is_discount')) {
            $filterConditions['is_discount'] = 1;
        }

        if ($request->has('is_season') && $request->boolean('is_season')) {
            $filterConditions['is_season'] = 1;
        }

        if ($request->has('is_popular') && $request->boolean('is_popular')) {
            $filterConditions['is_popular'] = 1;
        }

        $banner->update( [

            'filter_conditions' => $filterConditions,
            'is_active'=> $request->is_active,
            'en'=>[
                'title'=>$request->en_title,
                'description'=>$request->en_description,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'description'=>$request->ru_description,
            ]

        ]);

        return redirect()->back()->with('message','Banner updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {

        $banner->delete();
        return redirect()->route('banners.index')->with('message', 'Banner deleted successfully');

    }
}
