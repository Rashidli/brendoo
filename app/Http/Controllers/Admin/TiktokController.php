<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Tiktok;
use App\Services\ImageUploadService;
use App\Services\ProductAssignmentService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TiktokController extends Controller
{
    public function __construct(
        protected ImageUploadService $imageUploadService,
        protected ProductService $productService,
        protected ProductAssignmentService $productAssignmentService
    )
    {
        $this->middleware('permission:list-tiktoks|create-tiktoks|edit-tiktoks|delete-tiktoks', ['only' => ['index','show']]);
        $this->middleware('permission:create-tiktoks', ['only' => ['create','store']]);
        $this->middleware('permission:edit-tiktoks', ['only' => ['edit']]);
        $this->middleware('permission:delete-tiktoks', ['only' => ['destroy']]);
    }

    public function index()
    {
        $tiktoks = Tiktok::query()->paginate(10);
        return view('admin.tiktoks.index', compact('tiktoks'));
    }

    public function create()
    {
        return view('admin.tiktoks.create');
    }

    public function show(Request $request,Tiktok $tiktok)
    {
        $limit = $request->limit;
        if(!$limit){
            $limit = 5;
        }
        $products  = $this->productService->filterTitle($request->title)
            ->filterCode($request->code)
            ->filterIsActive($request->is_active)
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

        return view('admin.tiktoks.show',compact('tiktok','products','categories','subcategories','brands'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
            'image' => 'required'
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }

        Tiktok::create([
            'image'=> $filename,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('tiktoks.index')->with('message','Tiktok store successfully');
    }

    public function edit(Tiktok $tiktok)
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $brands = Brand::all();
        return view('admin.tiktoks.edit', compact('tiktok','categories','subCategories','brands' ));
    }

    public function update(Request $request, Tiktok $tiktok)
    {

        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
        ]);

        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $tiktok->image = $filename;
        }

        $tiktok->update( [
            'is_active' => $request->has('is_active'),
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->back()
            ->with('message', 'Tiktok updated successfully');

    }


    public function destroy(Tiktok $tiktok)
    {

        $tiktok->delete();
        return redirect()->route('tiktoks.index')
            ->with('success', 'Tiktok deleted successfully.');

    }

    public function assign(Tiktok $tiktok, $productId)
    {
        $result = $this->productAssignmentService->assignProduct($tiktok, $productId);
        return redirect()->back()->with($result['status'], $result['message']);
    }

    public function remove_assign(Tiktok $tiktok, $productId)
    {
        $result = $this->productAssignmentService->removeProduct($tiktok, $productId);
        return redirect()->back()->with($result['status'], $result['message']);
    }
}
