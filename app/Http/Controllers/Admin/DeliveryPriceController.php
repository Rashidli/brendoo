<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryPrice;
use Illuminate\Http\Request;

class DeliveryPriceController extends Controller
{
    public function index()
    {

        $delivery_prices = DeliveryPrice::query()->paginate(10);
        return view('admin.delivery_prices.index', compact('delivery_prices'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {

        return view('admin.delivery_prices.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title'=>'required',
        ]);

        DeliveryPrice::create([
            'title'=>$request->title,
        ]);

        return redirect()->route('delivery_prices.index')->with('message','DeliveryPrice added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(DeliveryPrice $delivery_price)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryPrice $delivery_price)
    {

        return view('admin.delivery_prices.edit', compact('delivery_price'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, DeliveryPrice $delivery_price)
    {

        $request->validate([
            'title'=>'required|numeric',
        ]);

        $delivery_price->update( [

            'title'=>$request->title,

        ]);

        return redirect()->back()->with('message','DeliveryPrice updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryPrice $delivery_price)
    {

        $delivery_price->delete();
        return redirect()->route('delivery_prices.index')->with('message', 'DeliveryPrice deleted successfully');

    }
}
