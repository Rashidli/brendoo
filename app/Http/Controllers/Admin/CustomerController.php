<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-customers|create-customers|edit-customers|delete-customers', ['only' => ['index','show']]);
        $this->middleware('permission:create-customers', ['only' => ['create','store']]);
        $this->middleware('permission:edit-customers', ['only' => ['edit']]);
        $this->middleware('permission:delete-customers', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        $query = Customer::query();

        if ($request->filled('id')) {
            $query->where('id',  $request->id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        $customers = $query->withCount('basketItems')
            ->withCount('favorites')
            ->orderByDesc('created_at')
            ->where('is_active', true)
            ->paginate(30)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {

        $customer->delete();
        return redirect()->route('customers.index')->with('message', 'Customer deleted successfully');

    }

    public function toggleStatus($id)
    {

        $user = Customer::query()->findOrFail($id);

        $user->is_blocked = !$user->is_blocked;
        $user->save();

        return redirect()->back()->with('message',$user->is_blocked ? 'Blok edildi' : 'Blokdan çıxarıldı');

    }
}
