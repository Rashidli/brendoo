<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductMain;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductMainController extends Controller
{
    public function index()
    {

        $product_mains = ProductMain::paginate(10);
        return view('admin.product_mains.index', compact('product_mains'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.product_mains.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'image'=>'required',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }

        ProductMain::create([
            'image'=>  $filename,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('product_mains.index')->with('message','ProductMain added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(ProductMain $product_main)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductMain $product_main)
    {

        return view('admin.product_mains.edit', compact('product_main'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, ProductMain $product_main)
    {
        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
        ]);

        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $product_main->image = $filename;
        }

        $product_main->update( [

            'is_active'=> $request->is_active,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);

        return redirect()->back()->with('message','ProductMain updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductMain $product_main)
    {

        $product_main->delete();
        return redirect()->route('product_mains.index')->with('message', 'ProductMain deleted successfully');

    }
}
