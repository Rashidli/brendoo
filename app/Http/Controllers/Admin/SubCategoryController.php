<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
        $this->middleware('permission:list-sub_categories|create-sub_categories|edit-sub_categories|delete-sub_categories', ['only' => ['index','show']]);
        $this->middleware('permission:create-sub_categories', ['only' => ['create','store']]);
        $this->middleware('permission:edit-sub_categories', ['only' => ['edit']]);
        $this->middleware('permission:delete-sub_categories', ['only' => ['destroy']]);
    }

    public function index()
    {
        $sub_categories = SubCategory::query()->paginate(50);
        return view('admin.sub_categories.index', compact('sub_categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.sub_categories.create', compact('categories'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
            'category_id' => 'required'
        ]);

        SubCategory::create([
            'category_id' =>$request->category_id,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('sub_categories.index')->with('message','Category store successfully');

    }

    public function edit(SubCategory $sub_category)
    {
        $categories = Category::all();
        return view('admin.sub_categories.edit', compact('sub_category' ,'categories'));
    }

    public function update(Request $request, SubCategory $sub_category)
    {

        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
            'category_id' => 'required'
        ]);

        $sub_category->update( [
            'category_id' =>$request->category_id,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);

        return redirect()->back()
            ->with('message', 'SubCategory updated successfully');

    }


    public function destroy(SubCategory $sub_category)
    {

        $sub_category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');

    }
}
