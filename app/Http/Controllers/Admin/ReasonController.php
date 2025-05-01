<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reason;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:list-reasons|create-reasons|edit-reasons|delete-reasons', ['only' => ['index','show']]);
//        $this->middleware('permission:create-reasons', ['only' => ['create','store']]);
//        $this->middleware('permission:edit-reasons', ['only' => ['edit']]);
//        $this->middleware('permission:delete-reasons', ['only' => ['destroy']]);
    }

    public function index()
    {

        $reasons = Reason::query()->paginate(10);
        return view('admin.reasons.index', compact('reasons'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.reasons.create');
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

        Reason::create([
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('reasons.index')->with('message','Reason added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Reason $reason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reason $reason)
    {

        return view('admin.reasons.edit', compact('reason'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Reason $reason)
    {
        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
        ]);

        $reason->update( [

            'is_active'=> $request->is_active,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);

        return redirect()->back()->with('message','Reason updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reason $reason)
    {

        $reason->delete();

        return redirect()->route('reasons.index')->with('message', 'Reason deleted successfully');

    }
}
