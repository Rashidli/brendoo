<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegisterImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterImageController extends Controller
{
    public function index()
    {

        $register_images = RegisterImage::paginate(10);
        return view('admin.register_images.index', compact('register_images'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.register_images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if($request->hasFile('register_image')){
            $file = $request->file('register_image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }

        RegisterImage::create([
            'register_image'=>  $filename,
        ]);

        return redirect()->route('register_images.index')->with('message','RegisterImage added successfully');

    }

    /**
     * Display the specified resource.
     */

    public function show(RegisterImage $register_images)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegisterImage $register_image)
    {

        return view('admin.register_images.edit', compact('register_image'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, RegisterImage $register_image)
    {

        if($request->hasFile('register_image')){

            $file = $request->file('register_image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $register_image->register_image = $filename;

        }

        $register_image->save();

        return redirect()->back()->with('message','RegisterImage updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegisterImage $register_image)
    {

        $register_image->delete();
        return redirect()->route('register_images.index')->with('message', 'RegisterImage deleted successfully');

    }
}
