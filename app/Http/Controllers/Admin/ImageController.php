<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-images|create-images|edit-images|delete-images', ['only' => ['index','show']]);
        $this->middleware('permission:create-images', ['only' => ['create','store']]);
        $this->middleware('permission:edit-images', ['only' => ['edit']]);
        $this->middleware('permission:delete-images', ['only' => ['destroy']]);
    }
    public function index()
    {

        $images = Image::paginate(10);
        return view('admin.images.index', compact('images'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }

        Image::create([
            'image'=>  $filename,
        ]);

        return redirect()->route('images.index')->with('message','Image added successfully');

    }

    /**
     * Display the specified resource.
     */

    public function show(Image $images)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {

        return view('admin.images.edit', compact('image'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Image $image)
    {

        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $image->image = $filename;

        }

        $image->save();

        return redirect()->back()->with('message','Image updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {

        $image->delete();
        return redirect()->route('images.index')->with('message', 'Image deleted successfully');

    }
}
