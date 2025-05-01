<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{

    public function index()
    {
        $districts = District::query()->paginate(10);
        return view('admin.districts.index', compact('districts'));
    }

    public function create()
    {
        $cities = City::all();
        return view('admin.districts.create', compact('cities'));
    }

    public function edit(District $district)
    {
        $cities = City::all();
        return view('admin.districts.edit', compact('cities','district'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id'
        ]);

        District::create([
            'name' => $request->name,
            'city_id' => $request->city_id
        ]);

        return redirect()->route('districts.index')->with('success', 'Rayon əlavə edildi');
    }

    public function update(District $district, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id'
        ]);

        $district->update([
            'name' => $request->name,
            'city_id' => $request->city_id
        ]);

        return redirect()->route('districts.create')->with('success', 'Rayon əlavə edildi');
    }

    public function destroy(District $districts)
    {

        $districts->delete();
        return redirect()->route('districts.index')->with('message', 'Qəsəbə deleted successfully');

    }

}
