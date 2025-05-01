<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class BasketController extends Controller
{

    public function index($id)
    {
        $customer = Customer::query()->with('basketItems.options')->findOrFail($id);
        $basketItems = $customer->basketItems()->get();
        return view('admin.baskets.index', compact('basketItems'));
    }

}
