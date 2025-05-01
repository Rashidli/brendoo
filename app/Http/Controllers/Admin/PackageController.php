<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Enums\AdminOrderStatus;
use App\Http\Enums\OrderStatus;
use App\Models\OrderItem;
use App\Models\Package;
use App\Services\OrderStatusService;
use App\Services\TopDeliveryService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function __construct(protected OrderStatusService $orderStatusService) {}

    public function index()
    {
        $query = Package::query()->with('orderItems');

        if (request()->filled('barcode')) {
            $query->where('barcode', 'like', '%' . request('barcode') . '%');
        }

        if (request()->filled('start_date')) {
            $query->whereDate('created_at', '>=', request('start_date'));
        }

        if (request()->filled('end_date')) {
            $query->whereDate('created_at', '<=', request('end_date'));
        }

        $packages = $query->latest()->paginate(50);

        return view('admin.packages.index', compact('packages'));
    }

    public function store(Request $request, TopDeliveryService $deliveryService)
    {
        try {
            // Request validation
            $request->validate([
                'order_item_ids'   => 'required|array',
                'order_item_ids.*' => 'exists:order_items,id',
                'weight'           => 'nullable|numeric',
                'tr_barcode'       => 'required|max:255',
                'note'             => 'nullable',
            ]);

            // Fetch order items
            $orderItems = OrderItem::with('customer', 'product.sub_category', 'product')
                ->whereIn('id', $request->order_item_ids)->get();

            $productsWithCategories = $orderItems->map(fn ($item) => [
                'product'  => $item->product?->title,
                'category' => $item->product?->sub_category?->title,
            ]);

            $customer = $orderItems->first()->order->customer ?? null;
            $order    = $orderItems->first()->order;

            // Prepare items for API
            $soapItems = $orderItems->map(fn ($item) => [
                'name'          => $item->product?->title ?? 'Unknown Product',
                'article'       => $item->product?->id    ?? 'N/A',
                'count'         => $item->quantity,
                'push'          => $item->quantity,
                'declaredPrice' => $item->price,
                'clientPrice'   => $item->price,
                'weight'        => 100, // default weight if not set
                'vat'           => 18,
            ])->toArray();

            // Prepare customer info
            $customerInfo = [
                'name'  => $customer ? $customer->name . ' ' . $customer->surname : 'Unknown Customer',
                'phone' => $customer->phone ?? '0000000000',
            ];

            // Generate unique order number
            $orderNumber = 'soaptest_25';

            // Prepare and send order data to API
            $orderData = $deliveryService->prepareOrderData(
                $soapItems,
                $request->weight,
                $customerInfo,
                $orderNumber
            );

            // Get barcode from API response
            $data = $deliveryService->createOrder($orderData);

            // Check if barcode is returned successfully
            if ($data['barcode']) {
                // If the barcode exists, create the package
                $package = Package::create([
                    'tr_barcode'            => $request->tr_barcode,
                    'weight'                => $request->weight,
                    'note'                  => $request->note,
                    'status'                => 'pending',
                    'barcode'               => $data['barcode'],
                    'top_delivery_order_id' => $data['orderId'],
                ]);

                $package->orderItems()->attach($request->order_item_ids);

                // Update order items status
                foreach ($orderItems as $item) {
                    $item->update([
                        'status'       => OrderStatus::Prepared,
                        'admin_status' => AdminOrderStatus::TurkishOffice,
                    ]);
                    $this->orderStatusService->updateStatus($item->id, OrderStatus::Prepared, AdminOrderStatus::TurkishOffice);
                }

                // Generate and store the waybill PDF
                //                $customerName = $customer ? $customer->name . ' ' . $customer->surname : 'Musteri yoxdur.';
                //                $pdf          = Pdf::loadView('admin.packages.waybill', [
                //                    'barcode'                => $data['barcode'], // API'dən gələn barcode
                //                    'customerName'           => $customerName,
                //                    'productsWithCategories' => $productsWithCategories,
                //                    'weight'                 => $request->weight,
                //                    'createdAt'              => now()->format('Y-m-d H:i'),
                //                    'itemCount'              => $orderItems->count(),
                //                ]);
                //
                //                $filename = "{$data['barcode']}.pdf";
                //                Storage::put("public/{$filename}", $pdf->output());
                //
                //                $package->update([
                //                    'waybill_path' => $filename,
                //                ]);

                $reportUrl = $deliveryService->printOrderAct(
                    $data['orderId'],
                    $data['barcode'],
                    $orderNumber
                );

                // (İstəyə görə) PDF faylını sistemə yüklə və package-ə əlavə et
//                $pdfContents = file_get_contents($reportUrl); // bu link PDF-dir
//                Storage::put("public/waybills/{$data['barcode']}_topdelivery.pdf", $pdfContents);

                // Update package with external TD waybill path
                $package->update([
                    'topdelivery_waybill_path' => $reportUrl,
                ]);

                return redirect()->route('offices.index');
            }
            // Handle the case where barcode is not returned
            throw new Exception('Failed to create order or get barcode from API');
        } catch (\Exception $exception) {
            // Log the error message
            Log::error('Error creating order: ' . $exception->getMessage());

            return $exception->getMessage();
        }
    }

    //    public function boxify(Request $request)
    //    {
    //        $request->validate([
    //            'package_ids' => 'required|array',
    //            'package_ids.*' => 'exists:packages,id',
    //        ]);
    //
    //        $packages = OrderItem::whereIn('id', $request->package_ids)->get();
    //
    //        foreach ($packages as $package) {
    //            $package->update([
    //                'status' => OrderStatus::Prepared,
    //                'admin_status' => AdminOrderStatus::TurkishOffice,
    //            ]);
    //        }
    //
    //        return redirect()->back()->with('message', 'Seçilmiş paketlər uğurla qutulaşdırıldı ✅');
    //    }

    // PackageController.php
    public function checkBarcode(Request $request)
    {
        $package = Package::where('barcode', $request->barcode)->with('boxes')->first();

        if ($package) {
            if ($package->boxes->isNotEmpty()) {
                return response()->json([
                    'exists'        => true,
                    'weight'        => $package->weight,
                    'already_boxed' => true,
                ]);
            }

            return response()->json([
                'exists'        => true,
                'weight'        => $package->weight,
                'already_boxed' => false,
            ]);
        }

        return response()->json([
            'exists' => false,
        ]);
    }
}
