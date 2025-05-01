<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
        $this->middleware('permission:list-faq_categories|create-faq_categories|edit-faq_categories|delete-faq_categories', ['only' => ['index','show']]);
        $this->middleware('permission:create-faq_categories', ['only' => ['create','store']]);
        $this->middleware('permission:edit-faq_categories', ['only' => ['edit']]);
        $this->middleware('permission:delete-faq_categories', ['only' => ['destroy']]);
    }

    public function index()
    {
        $faq_categories = FaqCategory::query()->paginate(10);
        return view('admin.faq_categories.index', compact('faq_categories'));
    }

    public function create()
    {

        return view('admin.faq_categories.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
        ]);

        FaqCategory::create([
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('faq_categories.index')->with('message','FaqCategory store successfully');
    }

    public function edit(FaqCategory $faq_category)
    {

        return view('admin.faq_categories.edit', compact('faq_category' ));
    }

    public function update(Request $request, FaqCategory $faq_category)
    {

        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
        ]);

        $faq_category->update( [

            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);

        return redirect()->back()
            ->with('message', 'FaqCategory updated successfully');

    }


    public function destroy(FaqCategory $faq_category)
    {

        $faq_category->delete();
        return redirect()->route('faq_categories.index')
            ->with('success', 'FaqCategory deleted successfully.');

    }
}
