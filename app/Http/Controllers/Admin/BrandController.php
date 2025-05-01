<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
        $this->middleware('permission:list-brands|create-brands|edit-brands|delete-brands', ['only' => ['index','show']]);
        $this->middleware('permission:create-brands', ['only' => ['create','store']]);
        $this->middleware('permission:edit-brands', ['only' => ['edit']]);
        $this->middleware('permission:delete-brands', ['only' => ['destroy']]);
    }

    public function index()
    {
        $brands = Brand::query()->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {

        return view('admin.brands.create');
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

        Brand::create([
            'image'=> $filename,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('brands.index')->with('message','Brand store successfully');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand' ));
    }

    public function update(Request $request, Brand $brand)
    {

        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
        ]);

        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $brand->image = $filename;
        }

        $brand->update( [

            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);



        return redirect()->back()
            ->with('message', 'Brand updated successfully');

    }


    public function destroy(Brand $brand)
    {

        $brand->delete();
        return redirect()->route('brands.index')
            ->with('success', 'Brand deleted successfully.');

    }
}
