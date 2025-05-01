<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Instagram;
use App\Models\Product;
use App\Models\SubCategory;
use App\Services\ImageUploadService;
use App\Services\ProductAssignmentService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstagramController extends Controller
{


    public function __construct(
        protected ImageUploadService $imageUploadService,
        protected ProductService $productService,
        protected ProductAssignmentService $productAssignmentService
    )
    {
        $this->middleware('permission:list-instagrams|create-instagrams|edit-instagrams|delete-instagrams', ['only' => ['index','show']]);
        $this->middleware('permission:create-instagrams', ['only' => ['create','store']]);
        $this->middleware('permission:edit-instagrams', ['only' => ['edit']]);
        $this->middleware('permission:delete-instagrams', ['only' => ['destroy']]);
    }

    public function index()
    {
        $instagrams = Instagram::query()->paginate(10);
        return view('admin.instagrams.index', compact('instagrams'));
    }

    public function create()
    {
        return view('admin.instagrams.create');
    }

    public function show(Request $request,Instagram $instagram)
    {
        $limit = $request->limit;
        if(!$limit){
            $limit = 5;
        }
        $products = $this->productService->filterProducts($request)->paginate($limit)->withQueryString();

        $categories = Category::all();
        $subcategories = SubCategory::all();
        $brands = Brand::all();

        return view('admin.instagrams.show',compact('instagram','products','categories','subcategories','brands'));
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

        Instagram::create([
            'image'=> $filename,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('instagrams.index')->with('message','Instagram store successfully');
    }

    public function edit(Instagram $instagram)
    {

        return view('admin.instagrams.edit', compact('instagram' ));

    }

    public function update(Request $request, Instagram $instagram)
    {

        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
        ]);

        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $instagram->image = $filename;
        }

        $instagram->update( [
//            'is_active' => $request->is_active,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->back()
            ->with('message', 'Instagram updated successfully');

    }


    public function destroy(Instagram $instagram)
    {

        $instagram->delete();
        return redirect()->route('instagrams.index')
            ->with('success', 'Instagram deleted successfully.');

    }

    public function assign(Instagram $instagram, $productId)
    {
        $result = $this->productAssignmentService->assignProduct($instagram, $productId);
        return redirect()->back()->with($result['status'], $result['message']);
    }

    public function remove_assign(Instagram $instagram, $productId)
    {
        $result = $this->productAssignmentService->removeProduct($instagram, $productId);
        return redirect()->back()->with($result['status'], $result['message']);
    }


}
