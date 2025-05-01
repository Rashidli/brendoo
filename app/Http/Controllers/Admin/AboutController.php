<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-abouts|create-abouts|edit-abouts|delete-abouts', ['only' => ['index','show']]);
        $this->middleware('permission:create-abouts', ['only' => ['create','store']]);
        $this->middleware('permission:edit-abouts', ['only' => ['edit']]);
        $this->middleware('permission:delete-abouts', ['only' => ['destroy']]);
    }

    public function index()
    {

        $abouts = About::paginate(10);
        return view('admin.abouts.index', compact('abouts'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.abouts.create');
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
            'image'=>'required',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }

        About::create([
            'image'=>  $filename,
            'en'=>[
                'title'=>$request->en_title,
                'description'=>$request->en_description,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'description'=>$request->ru_description,
            ]
        ]);

        return redirect()->route('abouts.index')->with('message','About added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(About $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(About $about)
    {

        return view('admin.abouts.edit', compact('about'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, About $about)
    {
        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
        ]);

        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $about->image = $filename;
        }

        $about->update( [

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

        return redirect()->back()->with('message','About updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(About $about)
    {

        $about->delete();
        return redirect()->route('abouts.index')->with('message', 'About deleted successfully');

    }
}
