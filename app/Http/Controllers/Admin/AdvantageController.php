<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advantage;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class AdvantageController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
        $this->middleware('permission:list-advantages|create-advantages|edit-advantages|delete-advantages', ['only' => ['index','show']]);
        $this->middleware('permission:create-advantages', ['only' => ['create','store']]);
        $this->middleware('permission:edit-advantages', ['only' => ['edit']]);
        $this->middleware('permission:delete-advantages', ['only' => ['destroy']]);
    }

    public function index()
    {

        $advantages = Advantage::query()->paginate(10);
        return view('admin.advantages.index', compact('advantages'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.advantages.create');
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
            $filename = $this->imageUploadService->upload($request->file('image'));
        }

        Advantage::create([
            'image'=>  $filename,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('advantages.index')->with('message','Advantage added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Advantage $advantage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advantage $advantage)
    {

        return view('admin.advantages.edit', compact('advantage'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Advantage $advantage)
    {
        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'image' => 'nullable'
        ]);

        if($request->hasFile('image')){
            $advantage->image = $this->imageUploadService->upload($request->file('image'));
        }

        $advantage->update( [

            'is_active'=> $request->is_active,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);

        return redirect()->back()->with('message','Advantage updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advantage $advantage)
    {

        $advantage->delete();

        return redirect()->route('advantages.index')->with('message', 'Advantage deleted successfully');

    }
}
