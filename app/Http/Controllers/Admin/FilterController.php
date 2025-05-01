<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filter;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-filters|create-filters|edit-filters|delete-filters', ['only' => ['index','show']]);
        $this->middleware('permission:create-filters', ['only' => ['create','store']]);
        $this->middleware('permission:edit-filters', ['only' => ['edit']]);
        $this->middleware('permission:delete-filters', ['only' => ['destroy']]);
    }
    public function index()
    {

        $filters = Filter::query()->paginate(10);
        return view('admin.filters.index', compact('filters'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.filters.create');
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

        Filter::create([
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('filters.index')->with('message','Filter added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Filter $filter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Filter $filter)
    {

        return view('admin.filters.edit', compact('filter'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Filter $filter)
    {
        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required'
        ]);

        $filter->update( [

            'is_active'=> $request->is_active,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);

        return redirect()->back()->with('message','Filter updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Filter $filter)
    {

        $filter->delete();
        return redirect()->route('filters.index')->with('message', 'Filter deleted successfully');

    }
}
