<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-deliveries|create-deliveries|edit-deliveries|delete-deliveries', ['only' => ['index','show']]);
        $this->middleware('permission:create-deliveries', ['only' => ['create','store']]);
        $this->middleware('permission:edit-deliveries', ['only' => ['edit']]);
        $this->middleware('permission:delete-deliveries', ['only' => ['destroy']]);
    }

    public function index()
    {

        $deliveries = Delivery::paginate(10);
        return view('admin.deliveries.index', compact('deliveries'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {

        return view('admin.deliveries.create');

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

        Delivery::create([
            'en'=>[
                'title'=>$request->en_title,
                'description'=>$request->en_description,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'description'=>$request->ru_description,
            ]
        ]);

        return redirect()->route('deliveries.index')->with('message','Delivery added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {
        return view('admin.deliveries.edit', compact('delivery'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Delivery $delivery)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
        ]);

        $delivery->update( [
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

        return redirect()->back()->with('message','Delivery updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {

        $delivery->delete();
        return redirect()->route('deliveries.index')->with('message', 'Delivery deleted successfully');

    }
}
