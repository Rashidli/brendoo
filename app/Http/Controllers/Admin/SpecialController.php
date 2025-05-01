<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Special;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class SpecialController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
        $this->middleware('permission:list-specials|create-specials|edit-specials|delete-specials', ['only' => ['index','show']]);
        $this->middleware('permission:create-specials', ['only' => ['create','store']]);
        $this->middleware('permission:edit-specials', ['only' => ['edit']]);
        $this->middleware('permission:delete-specials', ['only' => ['destroy']]);
    }

    public function index()
    {

        $specials = Special::paginate(10);
        return view('admin.specials.index', compact('specials'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {

        return view('admin.specials.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'en_discount'=>'required',
            'ru_discount'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
        ]);

        Special::create([

            'minute' => $request->minute,

            'en'=>[
                'discount'=>$request->en_discount,
                'description'=>$request->en_description,
            ],
            'ru'=>[
                'discount'=>$request->ru_discount,
                'description'=>$request->ru_description,
            ]

        ]);

        return redirect()->route('specials.index')->with('message','Special added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Special $special)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Special $special)
    {
        return view('admin.specials.edit', compact('special'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Special $special)
    {

        $request->validate([
            'en_discount'=>'required',
            'ru_discount'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
        ]);

        if ($request->hasFile('image')) {
            $special->image = $this->imageUploadService->upload($request->file('image'));
        }

        $special->update( [

            'is_active'=> $request->is_active,
            'minute'=> $request->minute,
            'en'=>[
                'discount'=>$request->en_discount,
                'description'=>$request->en_description,
            ],
            'ru'=>[
                'discount'=>$request->ru_discount,
                'description'=>$request->ru_description,
            ]

        ]);

        return redirect()->back()->with('message','Special updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Special $special)
    {

        $special->delete();
        return redirect()->route('specials.index')->with('message', 'Special deleted successfully');

    }
}
