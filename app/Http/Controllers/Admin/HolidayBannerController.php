<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HolidayBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HolidayBannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-holiday_banners|create-holiday_banners|edit-holiday_banners|delete-holiday_banners', ['only' => ['index','show']]);
        $this->middleware('permission:create-holiday_banners', ['only' => ['create','store']]);
        $this->middleware('permission:edit-holiday_banners', ['only' => ['edit']]);
        $this->middleware('permission:delete-holiday_banners', ['only' => ['destroy']]);
    }

    public function index()
    {

        $holiday_banners = HolidayBanner::paginate(10);
        return view('admin.holiday_banners.index', compact('holiday_banners'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {

        return view('admin.holiday_banners.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request->all());
        try {
            $request->validate([
                'en_title'=>'required',
                'ru_title'=>'required',
                'en_value'=>'required',
                'ru_value'=>'required',
                'en_description'=>'required',
                'ru_description'=>'required',
                'image'=>'required',
            ]);
            if($request->hasFile('image')){
                $file = $request->file('image');
                $filename = Str::uuid() . "." . $file->extension();
                $file->storeAs('public/',$filename);
            }
            HolidayBanner::create([
                'image'=>$filename,
                'en'=>[
                    'title'=>$request->en_title,
                    'value'=>$request->en_value,
                    'description'=>$request->en_description,
                ],
                'ru'=>[
                    'title'=>$request->ru_title,
                    'value'=>$request->ru_value,
                    'description'=>$request->ru_description,
                ]
            ]);

            return redirect()->route('holiday_banners.index')->with('message','HolidayBanner added successfully');
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(HolidayBanner $holiday_banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HolidayBanner $holiday_banner)
    {
        return view('admin.holiday_banners.edit', compact('holiday_banner'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, HolidayBanner $holiday_banner)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'en_value'=>'required',
            'ru_value'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
        ]);
        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $holiday_banner->image = $filename;
        }
        $holiday_banner->update( [
            'is_active'=> $request->is_active,
            'en'=>[
                'title'=>$request->en_title,
                'value'=>$request->en_value,
                'description'=>$request->en_description,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'value'=>$request->ru_value,
                'description'=>$request->ru_description,
            ]

        ]);

        return redirect()->back()->with('message','HolidayBanner updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HolidayBanner $holiday_banner)
    {

        $holiday_banner->delete();
        return redirect()->route('holiday_banners.index')->with('message', 'HolidayBanner deleted successfully');

    }
}
