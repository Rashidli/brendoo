<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-permissions|create-permissions|edit-permissions|delete-permissions', ['only' => ['index','show']]);
        $this->middleware('permission:create-permissions', ['only' => ['create','store']]);
        $this->middleware('permission:edit-permissions', ['only' => ['edit']]);
        $this->middleware('permission:delete-permissions', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate(['name'=>'required|unique:permissions,name', 'group_name'=>'required']);
        Permission::create($validated);

        return redirect()->route('permissions.index')->with('message','Permission əlavə olundu');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {

        $validated = $request->validate([
            'name'=>'required|unique:permissions,name,' . $permission->id,
            'group_name'=>'required'
        ]);
        $permission->update($validated);
        return redirect()->back()->with('message','Permission update olundu');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->back()->with('success','Permission silindi');
    }
}
