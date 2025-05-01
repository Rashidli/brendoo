<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index()
    {

        $refunds = Refund::paginate(10);
        return view('admin.refunds.index', compact('refunds'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {

        return view('admin.refunds.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
        ]);

        Refund::create([
            'en'=>[
                'title'=>$request->en_title,
                'description'=>$request->en_description,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'description'=>$request->ru_description,
            ]
        ]);

        return redirect()->route('refunds.index')->with('message','Refund added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Refund $refund)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Refund $refund)
    {
        return view('admin.refunds.edit', compact('refund'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Refund $refund)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
        ]);

        $refund->update( [
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

        return redirect()->back()->with('message','Refund updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Refund $refund)
    {

        $refund->delete();
        return redirect()->route('refunds.index')->with('message', 'Refund deleted successfully');

    }
}
