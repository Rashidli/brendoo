<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-roles|create-roles|edit-roles|delete-roles', ['only' => ['index','show']]);
        $this->middleware('permission:create-roles', ['only' => ['create','store']]);
        $this->middleware('permission:edit-roles', ['only' => ['edit']]);
        $this->middleware('permission:delete-roles', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */


    public function index()
    {

        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $permissions = Permission::all()->groupBy('group_name');
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        $validated = $request->validate(['name'=>'required']);
        $role = Role::create($validated);

        if($request->permission){
            foreach ($request->permission as $p){
                $role->givePermissionTo($p);
            }
        }


        return redirect()->route('roles.index')->with('message','Role əlavə olundu');
    }

    /**
     * Display the specified resource.
     */

    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy('group_name');
        return view('admin.roles.edit', compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Role $role)
    {

        $validated = $request->validate(['name'=>'required']);
        $role->update($validated);
        $role->syncPermissions();
        if($request->permission){
            foreach ($request->permission as $p){
                $role->givePermissionTo($p);
            }
        }


        return redirect()->back()->with('message','Role update olundu');

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Role $role)
    {

        $role->delete();
        return redirect()->back()->with('success','Role silindi');
    }
}
