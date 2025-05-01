<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Filter;
use App\Models\SubCategory;
use App\Models\ThirdCategory;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
        $this->middleware('permission:list-categories|create-categories|edit-categories|delete-categories', ['only' => ['index','show']]);
        $this->middleware('permission:create-categories', ['only' => ['create','store']]);
        $this->middleware('permission:edit-categories', ['only' => ['edit']]);
        $this->middleware('permission:delete-categories', ['only' => ['destroy']]);
    }

    public function index()
    {
        $categories = Category::query()->paginate(50);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $filters = Filter::active()->get();
        return view('admin.categories.create',compact('filters'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }

        $category = Category::create([
            'is_home' => $request->has('is_home'),
            'image'=> $filename,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        if ($request->has('filters')) {
            $category->filters()->attach($request->filters);
        }

        return redirect()->route('categories.index')->with('message','Category store successfully');
    }

    public function edit(Category $category)
    {
        $filters = Filter::active()->get();
        return view('admin.categories.edit', compact('category','filters'));
    }

    public function update(Request $request, Category $category)
    {

        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
        ]);

        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $category->image = $filename;
        }

        $category->update( [
            'is_home' => $request->has('is_home'),
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);

        if ($request->has('filters')) {
            $category->filters()->sync($request->filters);
        }

        return redirect()->back()
            ->with('message', 'Category updated successfully');

    }


    public function destroy(Category $category)
    {

        $category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');

    }

    public function getDetails($id)
    {
        $subCategories = SubCategory::query()->where('category_id', $id)->get();

        return response()->json([
            'sub_categories' => $subCategories,
        ]);
    }

    public function getThirdDetails($id)
    {
        $thirdCategories = ThirdCategory::query()->where('sub_category_id', $id)->get();

        return response()->json([
            'third_categories' => $thirdCategories,
        ]);
    }


}
