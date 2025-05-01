<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnProduct;
use Illuminate\Http\Request;

class ReturnProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $return_products = ReturnProduct::query()->with('customer','orderItem.product')->paginate(20);
        return view('admin.return_products.index', compact('return_products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ReturnProduct $returnProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReturnProduct $returnProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, ReturnProduct $returnProduct)
//    {
//        $returnProduct->status = $request->status;
//        $returnProduct->save();
//        return redirect()->back()->with('message','Status dəyişdirildi.');
//    }

    public function updateStatus(Request $request, $id)
    {
        $returnProduct = ReturnProduct::findOrFail($id);
        $returnProduct->status = $request->status;
        $returnProduct->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReturnProduct $returnProduct)
    {
        $returnProduct->delete();
        return redirect()->back()->with('message','İadə silindi');
    }
}
