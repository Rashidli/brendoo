<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Main;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
        $this->middleware('permission:list-mains|create-mains|edit-mains|delete-mains', ['only' => ['index','show']]);
        $this->middleware('permission:create-mains', ['only' => ['create','store']]);
        $this->middleware('permission:edit-mains', ['only' => ['edit']]);
        $this->middleware('permission:delete-mains', ['only' => ['destroy']]);
    }
    public function index()
    {

        $mains = Main::query()->paginate(10);
        return view('admin.mains.index', compact('mains'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.mains.create');
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
                'en_description'=>'required',
                'ru_description'=>'required',
                'image'=>'required',
            ]);

            if($request->hasFile('image')){
                $filename = $this->imageUploadService->upload($request->file('image'));
            }

            Main::create([
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
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

        return redirect()->route('mains.index')->with('message','Main added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Main $main)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Main $main)
    {

        return view('admin.mains.edit', compact('main'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Main $main)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
        ]);

        if($request->hasFile('image')){
            $main->image = $this->imageUploadService->upload($request->file('image'));
        }

        $main->update( [

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


        return redirect()->back()->with('message','Main updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Main $main)
    {

        $main->delete();

        return redirect()->route('mains.index')->with('message', 'Main deleted successfully');

    }
}
