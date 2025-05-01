<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::query()->paginate(10);
        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        return view('admin.cities.create');
    }

    public function edit(City $city)
    {
        return view('admin.cities.edit',compact('city'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        City::create(['name' => $request->name]);

        return redirect()->route('cities.index')->with('success', 'Şəhər əlavə edildi');
    }

    public function update(District $district,Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $district->update(['name' => $request->name]);

        return redirect()->route('cities.index')->with('success', 'Şəhər əlavə edildi');
    }

    public function destroy(City $city)
    {

        $city->delete();
        return redirect()->route('cities.index')->with('message', 'Şəhər deleted successfully');

    }
}
