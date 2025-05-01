<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-tags|create-tags|edit-tags|delete-tags', ['only' => ['index','show']]);
        $this->middleware('permission:create-tags', ['only' => ['create','store']]);
        $this->middleware('permission:edit-tags', ['only' => ['edit']]);
        $this->middleware('permission:delete-tags', ['only' => ['destroy']]);
    }
    public function index()
    {
        $tags = Tag::paginate(10);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        Tag::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('tags.index')->with('message', 'Tag added successfully');

    }

    public function show(Tag $tag)
    {
        //
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }


    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        $tag->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('message', 'Tag updated successfully');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('tags.index')->with('message', 'Tag deleted successfully');
    }
}
