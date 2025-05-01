<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-users|create-users|edit-users|delete-users', ['only' => ['index','show']]);
        $this->middleware('permission:create-users', ['only' => ['create','store']]);
        $this->middleware('permission:edit-users', ['only' => ['edit']]);
        $this->middleware('permission:delete-users', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $users = User::all();
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $roles = Role::query()->where('name', '!=', 'Super Admin')->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(RegisterRequest $request)
    {

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->assignRole($request->role);

//        if($request->role){
//            foreach ($request->role as $r){
//                $user->assignRole($r);
//            }
//        }


        $user->save();

//        Auth::login($user);

        return redirect()->route('users.index')->with('message', 'İstifadəçi əlavə edildi');

    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(User $user)
    {

        $roles = Role::query()->where('name', '!=', 'Super Admin')->get();
        return view('admin.users.edit', compact('user','roles'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->syncRoles();
        $user->assignRole($request->role);

//        if($request->role){
//            $user->syncRoles();
//
//            foreach ($request->role as $p){
//                $user->assignRole($p);
//            }
//        }

        $user->save();

        return redirect()->back()->with('message','İstifadəçi update edildi');

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(User $user)
    {
        if($user->id == 3){
            return redirect()->route('users.index')->with('message','Admini silmək olmaz');
        }

        $user->delete();
        return redirect()->route('users.index')->with('message','İstifadəçi silindi');
    }
}
