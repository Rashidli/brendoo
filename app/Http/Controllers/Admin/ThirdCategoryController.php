<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\ThirdCategory;
use App\Models\Filter;
use Illuminate\Http\Request;

class ThirdCategoryController extends Controller
{

    public function index()
    {
        $third_categories = ThirdCategory::query()->paginate(50);
        return view('admin.third_categories.index', compact('third_categories'));
    }

    public function create()
    {
        $sub_categories = SubCategory::all();
        return view('admin.third_categories.create', compact('sub_categories'));

    }

    public function store(Request $request)
    {

        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
        ]);

        ThirdCategory::create([
            'sub_category_id' =>$request->sub_category_id,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('third_categories.index')->with('message','ThirdCategory store successfully');

    }

    public function edit(ThirdCategory $third_category)
    {
        $sub_categories = SubCategory::all();
        return view('admin.third_categories.edit', compact('third_category','sub_categories'));
    }

    public function update(Request $request, ThirdCategory $third_category)
    {

        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
        ]);

        $third_category->update( [
            'sub_category_id' => $request->sub_category_id,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);


        return redirect()->back()
            ->with('message', 'ThirdCategory updated successfully');

    }

    public function destroy(ThirdCategory $third_category)
    {

        $third_category->delete();
        return redirect()->route('third_categories.index')
            ->with('success', 'ThirdCategory deleted successfully.');

    }

}
