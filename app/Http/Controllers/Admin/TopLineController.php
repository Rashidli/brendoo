<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopLine;
use Illuminate\Http\Request;

class TopLineController extends Controller
{
    public function index()
    {

        $top_lines = TopLine::query()->paginate(10);
        return view('admin.top_lines.index', compact('top_lines'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.top_lines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
        ]);

        TopLine::create([
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('top_lines.index')->with('message','TopLine added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(TopLine $top_line)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TopLine $top_line)
    {

        return view('admin.top_lines.edit', compact('top_line'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, TopLine $top_line)
    {
        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
        ]);

        $top_line->update( [

            'is_active'=> $request->is_active,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);

        return redirect()->back()->with('message','TopLine updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TopLine $top_line)
    {

        $top_line->delete();

        return redirect()->route('top_lines.index')->with('message', 'TopLine deleted successfully');

    }
}
