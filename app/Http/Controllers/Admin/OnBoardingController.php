<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnBoarding;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class OnBoardingController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
        $this->middleware('permission:list-on_boardings|create-on_boardings|edit-on_boardings|delete-on_boardings', ['only' => ['index','show']]);
        $this->middleware('permission:create-on_boardings', ['only' => ['create','store']]);
        $this->middleware('permission:edit-on_boardings', ['only' => ['edit']]);
        $this->middleware('permission:delete-on_boardings', ['only' => ['destroy']]);
    }

    public function index()
    {

        $on_boardings = OnBoarding::query()->paginate(10);
        return view('admin.on_boardings.index', compact('on_boardings'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.on_boardings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'en_title'=>'required',
                'ru_title'=>'required',
                'en_sub_title'=>'required',
                'ru_sub_title'=>'required',
                'image'=>'required',
            ]);

            if($request->hasFile('image')){
                $filename = $this->imageUploadService->upload($request->file('image'));
            }

            OnBoarding::create([
                'image'=>  $filename,
                'en'=>[
                    'title'=>$request->en_title,
                    'sub_title'=>$request->en_sub_title,
                ],
                'ru'=>[
                    'title'=>$request->ru_title,
                    'sub_title'=>$request->ru_sub_title,
                ]
            ]);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

        return redirect()->route('on_boardings.index')->with('message','OnBoarding added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(OnBoarding $on_boarding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OnBoarding $on_boarding)
    {

        return view('admin.on_boardings.edit', compact('on_boarding'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, OnBoarding $on_boarding)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'en_sub_title'=>'required',
            'ru_sub_title'=>'required',
        ]);

        if($request->hasFile('image')){
            $on_boarding->image = $this->imageUploadService->upload($request->file('image'));
        }

        $on_boarding->update( [

            'is_active'=> $request->is_active,
            'en'=>[
                'title'=>$request->en_title,
                'sub_title'=>$request->en_sub_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'sub_title'=>$request->ru_sub_title,
            ]

        ]);


        return redirect()->back()->with('message','OnBoarding updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OnBoarding $on_boarding)
    {

        $on_boarding->delete();

        return redirect()->route('on_boardings.index')->with('message', 'OnBoarding deleted successfully');

    }
}
