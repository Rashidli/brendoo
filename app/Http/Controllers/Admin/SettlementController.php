<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Settlement;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;

class SettlementController extends Controller
{

    public function index()
    {
        $settlements = Settlement::query()->paginate(10);
        return view('admin.settlements.index', compact('settlements'));
    }

    public function create()
    {
        $districts = District::all();
        return view('admin.settlements.create', compact('districts'));
    }

    public function edit(Settlement $settlement)
    {
        $districts = District::all();
        return view('admin.settlements.edit', compact('districts','settlement'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id'
        ]);

        Settlement::create([
            'name' => $request->name,
            'district_id' => $request->district_id
        ]);

        return redirect()->route('settlements.index')->with('success', 'Qəsəbə əlavə edildi');
    }

    public function update(Settlement $settlement,Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id'
        ]);

        $settlement->update([
            'name' => $request->name,
            'district_id' => $request->district_id
        ]);

        return redirect()->route('settlements.index')->with('success', 'Qəsəbə əlavə edildi');
    }

    public function destroy(Settlement $settlement)
    {

        $settlement->delete();
        return redirect()->route('settlements.index')->with('message', 'Bölgə deleted successfully');

    }

}
