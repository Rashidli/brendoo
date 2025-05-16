<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Enums\AdminOrderStatus;
use App\Http\Enums\OrderStatus;
use App\Models\Box;
use App\Models\City;
use App\Models\Package;
use App\Models\Region;
use App\Services\OrderStatusService;
use App\Services\TopDeliveryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BoxController extends Controller
{
    public function __construct(protected OrderStatusService $orderStatusService, protected TopDeliveryService $deliveryService) {}

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $packages = Package::whereIn('barcode', $request->package_barcodes)
                ->with('orderItems.order')
                ->get();

            $totalWeight = $packages->sum('weight');

            $box = Box::create([
                'number'       => $request->number,
                'total_weight' => $totalWeight,
                'note'         => $request->note,
            ]);

            $box->packages()->attach($packages->pluck('id'));

            $orders = [];
            $places = [];

            foreach ($packages as $package) {
                foreach ($package->orderItems as $orderItem) {
                    $orderItem->update([
                        'status'       => OrderStatus::Boxed,
                        'admin_status' => AdminOrderStatus::AdminBoxed,
                    ]);
                    $this->orderStatusService->updateStatus(
                        $orderItem->id,
                        OrderStatus::Boxed,
                        AdminOrderStatus::AdminBoxed
                    );
                }

                $orders[] = [
                    'orderId'       => $package->top_delivery_order_id,
                    'barcode'       => $package->barcode,
                    'webshopNumber' => $package->webshop_number,
                ];

                $places[] = [
                    'number'  => $box->number,
                    'weight'  => (float) $package->weight,
                    'pallets' => 0,
                ];
            }

            $shipmentData = [
                'intake_address'  => 'test intake address',
                'intake_contacts' => 'intake contacts',
                'intake_date'     => now()->addDays(3)->format('Y-m-d'),
                'intake_b_time'   => '10:00:00',
                'intake_e_time'   => '18:00:00',
                'comment'         => 'Box: ' . $box->number,
                'orders'          => $orders,
                'places'          => $places,
            ];

            $response   = $this->deliveryService->addShipment($shipmentData);
            $shipmentId = $response->addShipmentResult->shipmentId ?? null;

            $box->update([
                'shipment_id' => $shipmentId,
            ]);

            DB::commit();

            return redirect()->route('boxes.index')->with('success', 'Box created successfully!');

        } catch (Exception $e) {

            DB::rollBack();
            Log::error('Box creation failed', ['error' => $e->getMessage()]);

            return back()->withInput()->with('error', 'Failed to create box: ' . $e->getMessage());

        }
    }

    public function index(Request $request)
    {
        $query = Box::query()
            ->with(['packages.orderItems']) // Eager load
            ->when($request->number, fn ($q) => $q->where('number', 'like', "%{$request->number}%"))
            ->when($request->from, fn ($q) => $q->whereDate('created_at', '>=', $request->from))
            ->when($request->to, fn ($q) => $q->whereDate('created_at', '<=', $request->to))
            ->when($request->barcode, function ($q) use ($request): void {
                $q->whereHas('packages', function ($q) use ($request): void {
                    $q->where('barcode', 'like', "%{$request->barcode}%");
                });
            })
            ->when($request->customer_id, function ($q) use ($request): void {
                $q->whereHas('packages.orderItems', function ($q) use ($request): void {
                    $q->where('customer_id', $request->customer_id);
                });
            })
            ->orderByDesc('id');

        $boxes = $query->paginate(50)->appends($request->all());

        return view('admin.boxes.index', compact('boxes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.boxes.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(Box $box): void {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Box $box)
    {
        return view('admin.boxes.edit', compact('box'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Box $box)
    {
        $request->validate([
            'number'             => 'required',
            'package_barcodes'   => 'required|array',
            'package_barcodes.*' => 'exists:packages,barcode',
        ]);

        // Əvvəlki paketlərin statuslarını geri alırıq
        //        foreach ($box->packages as $oldPackage) {
        //            foreach ($oldPackage->orderItems as $orderItem) {
        //                $orderItem->update([
        //                    'status' => OrderStatus::InWarehouse,
        //                    'admin_status' => AdminOrderStatus::AdminInWarehouse,
        //                ]);
        //                $this->orderStatusService->updateStatus($orderItem->id, OrderStatus::InWarehouse, AdminOrderStatus::AdminInWarehouse);
        //            }
        //        }

        $newPackages = Package::query()->whereIn('barcode', $request->package_barcodes)->get();

        $totalWeight = $newPackages->sum('weight');

        $box->update([
            'number'       => $request->number,
            'note'         => $request->note,
            'total_weight' => $totalWeight,
        ]);

        $box->packages()->sync($newPackages->pluck('id'));

        foreach ($newPackages as $package) {
            foreach ($package->orderItems as $orderItem) {
                $orderItem->update([
                    'status'       => OrderStatus::Boxed,
                    'admin_status' => AdminOrderStatus::AdminBoxed,
                ]);
                $this->orderStatusService->updateStatus($orderItem->id, OrderStatus::Boxed, AdminOrderStatus::AdminBoxed);
            }
        }

        return redirect()->route('boxes.index')->with('message', 'Qutu uğurla yeniləndi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Box $box)
    {
        $box->delete();

        return redirect()->back()->with('message', 'Qutu silindi.');
    }

    public function bulkStatusUpdate(Request $request)
    {
        $request->validate([
            'box_ids'      => 'required|array',
            'status'       => 'required|string',
            'admin_status' => 'required|string',
        ]);

        $boxes = Box::with('packages.orderItems')->whereIn('id', $request->box_ids)->get();

        foreach ($boxes as $box) {
            foreach ($box->packages as $package) {
                foreach ($package->orderItems as $orderItem) {
                    $orderItem->update([
                        'status'       => OrderStatus::from($request->status),
                        'admin_status' => AdminOrderStatus::from($request->admin_status),
                    ]);
                }
            }

            $this->deliveryService->setShipmentOnTheWay($box->shipment_id);
        }

        return back()->with('message', 'Seçilmiş qutuların statusu uğurla yeniləndi!');
    }

    public function getRegions()
    {
        $response = $this->deliveryService->setRegions();
        return response()->json($response);
//        foreach ($response->citiesRegions as $region) {
//            Region::create([
//                'regionId' => $region->regionId,
//                'regionName' => $region->regionName,
//            ]);
//
//            // Əgər cities array deyilsə, onu arrayə çevir
//            $cities = is_array($region->cities) ? $region->cities : [$region->cities];
//
//            foreach ($cities as $city) {
//                City::create([
//                    'cityId' => $city->cityId,
//                    'cityName' => $city->cityName,
//                    'regionId' => $region->regionId,
//                ]);
//            }
//        }

        return response()->json([
            'message' => 'Regions added successfully'
        ]);
    }

}
