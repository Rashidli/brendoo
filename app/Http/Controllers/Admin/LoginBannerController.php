<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginBannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-login_banners|create-login_banners|edit-login_banners|delete-login_banners', ['only' => ['index','show']]);
        $this->middleware('permission:create-login_banners', ['only' => ['create','store']]);
        $this->middleware('permission:edit-login_banners', ['only' => ['edit']]);
        $this->middleware('permission:delete-login_banners', ['only' => ['destroy']]);
    }

    public function index()
    {

        $login_banners = LoginBanner::query()->paginate(10);
        return view('admin.login_banners.index', compact('login_banners'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.login_banners.create');
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

        if($request->hasFile('second_image')){
            $file = $request->file('second_image');
            $filename_second_image = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename_second_image);
        }

        LoginBanner::create([
            'image'=>  $filename,
            'second_image'=>  $filename_second_image,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('login_banners.index')->with('message','LoginBanner added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(LoginBanner $login_banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoginBanner $login_banner)
    {

        return view('admin.login_banners.edit', compact('login_banner'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, LoginBanner $login_banner)
    {
        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
        ]);

        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $login_banner->image = $filename;
        }

        if($request->hasFile('second_image')){

            $file = $request->file('second_image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $login_banner->second_image = $filename;
        }

        $login_banner->update( [

            'is_active'=> $request->is_active,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);

        return redirect()->back()->with('message','LoginBanner updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoginBanner $login_banner)
    {

        $login_banner->delete();
        return redirect()->route('login_banners.index')->with('message', 'LoginBanner deleted successfully');

    }
}
