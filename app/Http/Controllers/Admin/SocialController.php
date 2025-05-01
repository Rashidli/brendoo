<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SocialController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:list-socials|create-socials|edit-socials|delete-socials', ['only' => ['index','show']]);
        $this->middleware('permission:create-socials', ['only' => ['create','store']]);
        $this->middleware('permission:edit-socials', ['only' => ['edit']]);
        $this->middleware('permission:delete-socials', ['only' => ['destroy']]);
    }
    public function index()
    {
        $socials = Social::paginate(10);
        return view('admin.socials.index', compact('socials'));
    }

    public function create()
    {
        return view('admin.socials.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'required|url',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }

        Social::create([
            'title' => $request->title,
            'image'=>  $filename,
            'link' => $request->link,
        ]);

        return redirect()->route('socials.index')->with('message', 'Social added successfully');

    }

    public function show(Social $social)
    {
        //
    }

    public function edit(Social $social)
    {
        return view('admin.socials.edit', compact('social'));
    }


    public function update(Request $request, Social $social)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'required|url',
        ]);

        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $social->image = $filename;
        }

        $social->update([
            'title' => $request->title,
            'link' => $request->link,
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('message', 'Social updated successfully');
    }

    public function destroy(Social $social)
    {
        $social->delete();
        return redirect()->route('socials.index')->with('message', 'Social deleted successfully');
    }
}
