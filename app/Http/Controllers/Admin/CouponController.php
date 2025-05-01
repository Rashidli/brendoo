<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{

    public function __construct(protected ImageUploadService $imageUploadService)
    {
        $this->middleware('permission:list-coupons|create-coupons|edit-coupons|delete-coupons', ['only' => ['index','show']]);
        $this->middleware('permission:create-coupons', ['only' => ['create','store']]);
        $this->middleware('permission:edit-coupons', ['only' => ['edit']]);
        $this->middleware('permission:delete-coupons', ['only' => ['destroy']]);
    }

    public function index()
    {
        $coupons = Coupon::query()->paginate(20);
        return view('admin.coupons.index', compact('coupons'));
    }

    // Show the form to create a new coupon (store)
    public function create()
    {
        return view('admin.coupons.create');
    }

    // Store a new coupon in the database (store)
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:coupons,code',
            'discount' => 'required|numeric',
            'type' => 'required|in:percentage,amount',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Creating a new coupon
        Coupon::create([
            'code' => $request->input('code'),
            'discount' => $request->input('discount'),
            'type' => $request->input('type'),
            'valid_from' => $request->input('valid_from'),
            'valid_until' => $request->input('valid_until'),
            'is_active' => $request->input('is_active', true), // Default active
        ]);

        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
    }

    // Show the form to edit an existing coupon (edit)
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    // Update an existing coupon (update)
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        // Validation
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'discount' => 'required|numeric',
            'type' => 'required|in:percentage,amount',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Updating the coupon
        $coupon->update([
            'code' => $request->input('code'),
            'discount' => $request->input('discount'),
            'type' => $request->input('type'),
            'valid_from' => $request->input('valid_from'),
            'valid_until' => $request->input('valid_until'),
            'is_active' => $request->input('is_active', true),
        ]);

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully.');
    }

    // Delete an existing coupon (delete)
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);

        // Deleting the coupon
        $coupon->delete();

        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
