<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Enums\AdminOrderStatus;
use App\Http\Enums\OrderStatus;
use App\Models\Box;
use App\Models\Package;
use App\Services\OrderStatusService;
use Illuminate\Http\Request;

class BoxController extends Controller
{

//    public function topDelivery(Box $box)
//    {
//        $soap = new \SoapClient('http://is-test.topdelivery.ru/api/soap/w/2.0/?wsdl', [
//            'login' => 'tdsoap',
//            'password' => '5f3b5023270883afb9ead456c8985ba8',
//        ]);
//
//        $items = [];
//        $totalDeclaredPrice = 0;
//
//        foreach ($box->packages as $package) {
//            foreach ($package->orderItems as $item) {
//                $items[] = [
//                    'name' => $item->product->title,
//                    'article' => $item->product->code ?? 'no-code',
//                    'count' => 1,
//                    'push' => 1,
//                    'declaredPrice' => (float)$item->price,
//                    'clientPrice' => (float)$item->price,
//                    'weight' => (int)($item->weight ?? 200),
//                    'vat' => 18,
//                    'itemCode' => $item->id, // Sifariş elementinin ID-si
//                    'itemBarcode' => $item->barcode ?? null, // Elementin barkodu
//                ];
//
//                $totalDeclaredPrice += (float)$item->price;
//            }
//        }
//
//        // Müştəri məlumatları
//        $firstOrderItem = $box->packages->first()?->orderItems->first();
//        $customer = $firstOrderItem?->customer;
//        $customerName = $customer?->full_name ?? 'Customer Name';
//        $customerPhone = $customer?->phone ?? '0000000000';
//        $customerEmail = $customer?->email ?? null;
//
//        // Qutunun ölçüləri (sizin sisteminizdə varsa, yoxdursa default)
//        $boxLength = $box->length ?? 30;
//        $boxWidth = $box->width ?? 20;
//        $boxHeight = $box->height ?? 15;
//
//        $params = [
//            'auth' => [
//                'login' => 'webshop',
//                'password' => 'pass',
//            ],
//            'addedOrders' => [
//                [
//                    'serviceType' => 'DELIVERY',
//                    'orderSubtype' => 'SIMPLE',
//                    'deliveryType' => 'COURIER', // və ya 'COURIER' ünvan çatdırılması üçün
//                    'webshopNumber' => $box->number,
//                    'paymentByCard' => 0,
//                    'deliveryCostPayAnyway' => 0, // İmtina halında çatdırılma haqqı alınmasın
//
//                    // Çatdırılma tarixi və vaxtı
//                    'desiredDateDelivery' => [
//                        'date' => now()->addDays(2)->format('Y-m-d'), // 2 gün sonra
//                        'timeInterval' => [
//                            'bTime' => '10:00',
//                            'eTime' => '18:00',
//                        ],
//                    ],
//
//                    // Çatdırılma ünvanı (PICKUP üçün P/VZ seçimi)
//                    'deliveryAddress' => [
//                        'type' => 'pickup',
//                        'pickupAddress' => [
//                            'id' => '20', // P/VZ ID-si
//                            // 'partnerPickupCode' => 'PVZ123' // P/VZ kodu (lazım olsa)
//                        ],
//                    ],
//
//                    // Müştəri məlumatları
//                    'clientInfo' => [
//                        'fio' => $customerName,
//                        'phone' => $customerPhone,
//                        'email' => $customerEmail,
//                        'comment' => $box->note ?? null,
//                    ],
//
//                    // Qiymət məlumatları
//                    'clientCosts' => [
//                        'clientDeliveryCost' => 300, // Çatdırılma haqqı
//                        'recalcDelivery' => 0,
//                        'discount' => [
//                            'type' => 'SUM',
//                            'value' => 0,
//                        ],
//                    ],
//
//                    // Xidmətlər
//                    'services' => [
//                        'notOpen' => 0, // Açılmaması tələbi
//                        'marking' => 0, // Markirovka
//                        'smsNotify' => 1, // SMS bildiriş
//                        'forChoise' => 0, // Qismən realizasiya
//                        'places' => $box->packages->count(), // Paket sayı
//                        'pack' => [
//                            'need' => 0, // Paketləmə tələbi
//                            'type' => '',
//                        ],
//                        'needPrr' => $box->total_weight > 10000 ? 1 : 0, // 10 kq-dan çoxsa yükləmə-boşaltma
//                    ],
//
//                    // Çəki və ölçülər
//                    'deliveryWeight' => [
//                        'weight' => $box->total_weight ?? 200,
//                        'volume' => [
//                            'length' => $boxLength,
//                            'width' => $boxWidth,
//                            'height' => $boxHeight,
//                        ],
//                    ],
//
//                    // Məhsul siyahısı
//                    'items' => $items,
//
//                    // Əlavə parametrlər
//                    'orderUrl' => route('boxes.show', $box->id), // Qutuya link
//                    'webshopBarcode' => $box->barcode ?? null, // Qutu barkodu
//                ],
//            ],
//        ];
//
//        try {
//            $response = $soap->addOrders(['addOrders' => $params]);
//            logger()->info('TopDelivery Response', ['response' => $response]);
//
//            // Uğurlu göndərilmə halında qutunu qeyd edək
//            $box->update([
//                'sent_to_delivery' => true,
//                'delivery_response' => json_encode($response),
//            ]);
//
//            return $response;
//        } catch (\Exception $e) {
//            logger()->error('TopDelivery Error', [
//                'error' => $e->getMessage(),
//                'box_id' => $box->id,
//            ]);
//
//            throw $e; // və ya xətanı idarə etmək üçün fərqli yanaşma
//        }
//    }



    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'package_barcodes' => 'required|array',
            'package_barcodes.*' => 'exists:packages,barcode',
        ]);

        $packages = Package::query()->whereIn('barcode', $request->package_barcodes)->get();

        $totalWeight = $packages->sum('weight');

        $box = Box::create([
            'number' => $request->number,
            'total_weight' => $totalWeight,
            'note' => $request->note,
        ]);

        $box->packages()->attach($packages->pluck('id'));

        foreach ($packages as $package) {
            foreach ($package->orderItems as $orderItem) {
                $orderItem->update([
                    'status' => OrderStatus::Boxed,
                    'admin_status' => AdminOrderStatus::AdminBoxed,
                ]);
                $this->orderStatusService->updateStatus($orderItem->id, OrderStatus::Boxed, AdminOrderStatus::AdminBoxed);
            }
        }


//        return  $this->topDelivery($box);


        return redirect()->route('boxes.index')->with('message', 'Qutu uğurla yaradıldı!');
    }

    public function __construct(protected OrderStatusService $orderStatusService)
    {

    }

    public function index(Request $request)
    {
        $query = Box::query()
            ->with(['packages.orderItems']) // Eager load
            ->when($request->number, fn($q) => $q->where('number', 'like', "%{$request->number}%"))
            ->when($request->from, fn($q) => $q->whereDate('created_at', '>=', $request->from))
            ->when($request->to, fn($q) => $q->whereDate('created_at', '<=', $request->to))
            ->when($request->barcode, function ($q) use ($request) {
                $q->whereHas('packages', function ($q) use ($request) {
                    $q->where('barcode', 'like', "%{$request->barcode}%");
                });
            })
            ->when($request->customer_id, function ($q) use ($request) {
                $q->whereHas('packages.orderItems', function ($q) use ($request) {
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
    public function show(Box $box)
    {
        //
    }

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
            'number' => 'required',
            'package_barcodes' => 'required|array',
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
            'number' => $request->number,
            'note' => $request->note,
            'total_weight' => $totalWeight,
        ]);

        $box->packages()->sync($newPackages->pluck('id'));

        foreach ($newPackages as $package) {
            foreach ($package->orderItems as $orderItem) {
                $orderItem->update([
                    'status' => OrderStatus::Boxed,
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
}
