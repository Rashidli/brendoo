<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Single;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SingleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:list-singles|create-singles|edit-singles|delete-singles', ['only' => ['index','show']]);
        $this->middleware('permission:create-singles', ['only' => ['create','store']]);
        $this->middleware('permission:edit-singles', ['only' => ['edit']]);
        $this->middleware('permission:delete-singles', ['only' => ['destroy']]);
    }
    function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = Single::whereTranslation('title', $title)->count();

        if ($count > 0) {
            $slug .= '-' . $count;
        }

        return $slug;
    }

    public function index()
    {

        $singles = Single::paginate(10);
        return view('admin.singles.index', compact('singles'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.singles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
        ]);

        Single::create([
            'type'=>  $request->type,
            'en'=>[
                'title'=>$request->en_title,
                'seo_title'=>$request->en_seo_title,
                'seo_description'=>$request->en_seo_description,
                'seo_keywords'=>$request->en_seo_keywords,
                'slug'=>$this->generateUniqueSlug($request->en_title),
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'seo_title'=>$request->ru_seo_title,
                'seo_description'=>$request->ru_seo_description,
                'seo_keywords'=>$request->ru_seo_keywords,
                'slug'=>$this->generateUniqueSlug($request->ru_title),
            ]
        ]);

        return redirect()->route('singles.index')->with('message','Single added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Single $single)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Single $single)
    {

        return view('admin.singles.edit', compact('single'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Single $single)
    {
        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
        ]);



        $single->update( [
            'type'=>  $request->type,
            'en'=>[
                'title'=>$request->en_title,
                'seo_title'=>$request->en_seo_title,
                'seo_description'=>$request->en_seo_description,
                'seo_keywords'=>$request->en_seo_keywords,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'seo_title'=>$request->ru_seo_title,
                'seo_description'=>$request->ru_seo_description,
                'seo_keywords'=>$request->ru_seo_keywords,
            ]

        ]);

        return redirect()->back()->with('message','Single updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Single $single)
    {

        $single->delete();

        return redirect()->route('singles.index')->with('message', 'Single deleted successfully');

    }
}
