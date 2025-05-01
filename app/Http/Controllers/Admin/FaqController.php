<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-faqs|create-faqs|edit-faqs|delete-faqs', ['only' => ['index','show']]);
        $this->middleware('permission:create-faqs', ['only' => ['create','store']]);
        $this->middleware('permission:edit-faqs', ['only' => ['edit']]);
        $this->middleware('permission:delete-faqs', ['only' => ['destroy']]);
    }

    public function index()
    {

        $faqs = Faq::paginate(10);
        return view('admin.faqs.index', compact('faqs'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {

        $faq_categories = FaqCategory::all();
        return view('admin.faqs.create', compact('faq_categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
            'faq_category_id'=>'required',
        ]);

        Faq::create([
            'faq_category_id' => $request->faq_category_id,
            'en'=>[
                'title'=>$request->en_title,
                'description'=>$request->en_description,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'description'=>$request->ru_description,
            ]
        ]);

        return redirect()->route('faqs.index')->with('message','Faq added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        $faq_categories = FaqCategory::all();
        return view('admin.faqs.edit', compact('faq','faq_categories'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Faq $faq)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
            'faq_category_id'=>'required',
        ]);

        $faq->update( [
            'faq_category_id' => $request->faq_category_id,
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

        return redirect()->back()->with('message','Faq updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {

        $faq->delete();

        return redirect()->route('faqs.index')->with('message', 'Faq deleted successfully');

    }
}
