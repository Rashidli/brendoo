<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::query()->paginate(10);
        return view('admin.regions.index', compact('regions'));
    }

    public function create()
    {
        return view('admin.regions.create');
    }

    public function edit(Region $region)
    {
        return view('admin.regions.edit',compact('region'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'regionName' => 'required|string|max:255',
            'regionId' => 'integer|string|max:9'
        ]);

        Region::create([
            'regionName' => $request->regionName,
            'regionId' => $request->regionId,
        ]);

        return redirect()->route('regions.index')->with('success', 'Region əlavə edildi');
    }

    public function update(Region $region,Request $request)
    {
        $request->validate([
            'regionName' => 'required|string|max:255',
            'regionId' => 'integer|string|max:9'
        ]);

        $region->update([
            'regionName' => $request->regionName,
            'regionId' => $request->regionId,
        ]);

        return redirect()->route('regions.index')->with('success', 'Region əlavə edildi');
    }

    public function destroy(Region $region)
    {

        $region->delete();
        return redirect()->route('regions.index')->with('message', 'Region deleted successfully');

    }
}
