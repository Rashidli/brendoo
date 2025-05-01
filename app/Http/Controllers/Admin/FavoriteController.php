<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{

    public function index($id)
    {
        $customer = Customer::query()->with('favorites.product')->findOrFail($id);
        $favorites = $customer->favorites()->get();
        return view('admin.favorites.index', compact('favorites'));
    }

}
