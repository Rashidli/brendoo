<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Region;
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
        $regions = Region::all();
        return view('admin.cities.create', compact('regions'));
    }

    public function edit(City $city)
    {
        $regions = Region::all();
        return view('admin.cities.edit',compact('city','regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cityName' => 'required|string|max:255',
            'cityId' => 'required|integer|max:255',
            'regionId' => 'required|integer|max:255',
        ]);

        City::create([
            'cityName' => $request->cityName,
            'cityId' => $request->cityId,
            'regionId' => $request->regionId,
        ]);

        return redirect()->route('cities.index')->with('success', 'Şəhər əlavə edildi');
    }

    public function update(District $district,Request $request)
    {
        $request->validate([
            'cityName' => 'required|string|max:255',
            'cityId' => 'required|integer|max:255',
            'regionId' => 'required|integer|max:255',
        ]);

        $district->update([
            'cityName' => $request->cityName,
            'cityId' => $request->cityId,
            'regionId' => $request->regionId,
        ]);

        return redirect()->route('cities.index')->with('success', 'Şəhər əlavə edildi');
    }

    public function destroy(City $city)
    {

        $city->delete();
        return redirect()->route('cities.index')->with('message', 'Şəhər deleted successfully');

    }
}
