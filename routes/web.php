<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdvantageController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BasketController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BoxController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContactItemController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\DeliveryPriceController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FavoriteController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\HolidayBannerController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\InspectionController;
use App\Http\Controllers\Admin\InstagramController;
use App\Http\Controllers\Admin\LoginBannerController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\OnBoardingController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductMainController;
use App\Http\Controllers\Admin\ReasonController;
use App\Http\Controllers\Admin\RefundController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\RegisterImageController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReturnProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Admin\SettlementController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\SingleController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\SpecialController;
use App\Http\Controllers\Admin\StockNotificationController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\ThirdCategoryController;
use App\Http\Controllers\Admin\TiktokController;
use App\Http\Controllers\Admin\TopLineController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WordController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

//Route::get('storage_link', function (){
//    return \Illuminate\Support\Facades\Artisan::call('storage:link');
//});
//
//Route::get('migrate', function (){
//    return \Illuminate\Support\Facades\Artisan::call('migrate');
//});
//
//Route::get('cache_reset', function (){
//    return \Illuminate\Support\Facades\Artisan::call('permission:cache-reset');
//});
//
//Route::get('optimize', function (){
//    return \Illuminate\Support\Facades\Artisan::call('optimize:clear');
//});

Route::get('test',[BlogController::class,'test']);

Route::get('/test-mail', function () {
    try {
        Mail::raw('Test email', function ($message) {
            $message->to('rashidliseymur@gmail.com')->subject('Test Email');
        });

        return 'Mail sent successfully!';
    } catch (\Exception $e) {
        return 'Mail failed: ' . $e->getMessage();
    }
});

Route::get('/', [PageController::class,'login'])->name('login');
//Route::get('/register', [PageController::class,'register'])->name('register');
Route::post('/login_submit',[AuthController::class,'login_submit'])->name('login_submit');
//Route::post('/register_submit',[AuthController::class,'register_submit'])->name('register_submit');
Route::get('importjson',[TranslationController::class,'importTranslations']);
Route::group(['middleware' =>'auth'], function (){

    Route::get('/home', [PageController::class,'home'])->name('home');
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
    Route::resource('users',UserController::class);
    Route::resource('on_boardings',OnBoardingController::class);
    Route::resource('translations',TranslationController::class);
    Route::resource('roles',RoleController::class);
    Route::resource('permissions',PermissionController::class);
    Route::get('/admin/check-barcode', [PackageController::class, 'checkBarcode']);
    Route::post('/send-bulk-notification', [NotificationController::class, 'sendBulkNotification'])->name('sendBulkNotification');
    Route::post('/sendSingleNotification', [NotificationController::class, 'sendSingleNotification'])->name('sendSingleNotification');
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('admin.logs.index');
    Route::post('/products/upload-excel', [ProductController::class, 'uploadExcel'])->name('products.uploadExcel');
    Route::post('import',[ProductController::class,'import'])->name('xml.import');
    Route::post('zara-import',[ProductController::class,'zaraImport'])->name('zara.import');
    Route::post('increase-prices',[ProductController::class,'increasePrices'])->name('increase-prices');

    Route::get('index/{id}',[NoticeController::class, 'index'])->name('notices.index');
    Route::post('packages/store',[PackageController::class, 'store'])->name('packages.store');
    Route::get('packages/index',[PackageController::class, 'index'])->name('packages.index');
    Route::post('/packages/boxify', [PackageController::class, 'boxify'])->name('packages.boxify');

    Route::resource('boxes', BoxController::class);
    Route::post('admin/boxes/bulk-status-update', [BoxController::class, 'bulkStatusUpdate'])->name('boxes.bulk-status-update');


    Route::resource('return_products',ReturnProductController::class);
    Route::post('/admin/return-products/{id}/update-status', [ReturnProductController::class, 'updateStatus']);


    Route::resource('cities',CityController::class);
    Route::resource('districts',DistrictController::class);
    Route::resource('settlements',SettlementController::class);
    Route::resource('reports', ReportController::class);
    Route::resource('regions', RegionController::class);
    Route::get('get-regions', [BoxController::class, 'getRegions']);

    Route::resource('blogs',BlogController::class);
    Route::resource('stock_notifications',StockNotificationController::class);
    Route::post('send_email_stock_notifications',[StockNotificationController::class,'sendEmailStockNotifications'])->name('send_email_stock_notifications');
    Route::resource('subscriptions',SubscriptionController::class);
    Route::resource('socials',SocialController::class);
    Route::resource('contact_items',ContactItemController::class);
    Route::resource('singles',SingleController::class);
    Route::resource('words',WordController::class);
    Route::resource('images',ImageController::class);
    Route::resource('categories',CategoryController::class);
    Route::resource('sub_categories',SubCategoryController::class);
    Route::resource('third_categories',ThirdCategoryController::class);
    Route::resource('contacts',ContactController::class);
    Route::resource('brands',BrandController::class);
    Route::resource('faqs',FaqController::class);
    Route::resource('advantages',AdvantageController::class);
    Route::resource('faq_categories',FaqCategoryController::class);
    Route::resource('tags',TagController::class);
    Route::resource('abouts',AboutController::class);
    Route::resource('customers',CustomerController::class);
    Route::resource('filters',FilterController::class);
    Route::resource('products',ProductController::class);
    Route::resource('inspections',InspectionController::class);
    Route::resource('mains',MainController::class);
    Route::resource('tiktoks',TiktokController::class);
    Route::resource('instagrams',InstagramController::class);
    Route::resource('specials',SpecialController::class);
    Route::resource('login_banners',LoginBannerController::class);
    Route::resource('holiday_banners',HolidayBannerController::class);
    Route::resource('comments',CommentController::class);
    Route::resource('reasons',ReasonController::class);
    Route::resource('top_lines',TopLineController::class);
    Route::resource('delivery_prices',DeliveryPriceController::class);
    Route::resource('coupons',CouponController::class);
    Route::resource('shops',ShopController::class);
    Route::resource('product_mains',ProductMainController::class);
    Route::resource('banners',BannerController::class);
    Route::resource('register_images',RegisterImageController::class);
    Route::get('favorites/{id}',[FavoriteController::class, 'index'])->name('favorites.index');
    Route::get('baskets/{id}',[BasketController::class,'index'])->name('customer_basket');
    Route::resource('orders', OrderController::class);
    Route::post('get-status-delivery', [PackageController::class, 'getStatusDelivery'])->name('check.status.topdelivery');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::put('/admin_orders/{id}/status', [OrderController::class, 'updateAdminStatus'])->name('admin_orders.updateStatus');
    Route::post('/orders/{orderId}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('toggle_order_item_status/{product_id}', [OrderController::class,'toggle_order_item_status'])->name('toggle_order_item_status');
    Route::get('toggle_is_complete/{id}', [OrderController::class,'toggleIsComplete'])->name('toggle_is_complete');
    Route::post('/customer/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customer.toggleStatus');

    Route::get('instagram_assign/{instagram}/{product_id}',[InstagramController::class, 'assign'])->name('assign_instagram');
    Route::delete('remove_assign_instagram/{instagram}/{product_id}',[InstagramController::class, 'remove_assign'])->name('remove_assign_instagram');

    Route::get('assign_tiktok/{tiktok}/{product_id}',[TiktokController::class, 'assign'])->name('assign_tiktok');
    Route::delete('remove_assign_tiktok/{tiktok}/{product_id}',[TiktokController::class, 'remove_assign'])->name('remove_assign_tiktok');

    Route::resource('rules',RuleController::class);
    Route::resource('refunds',RefundController::class);

    Route::resource('deliveries',DeliveryController::class);
    Route::resource('filters.options',OptionController::class);
    Route::get('/categories/{id}/details', [CategoryController::class, 'getDetails'])->name('categories.details');
    Route::get('/sub_categories/{id}/details', [CategoryController::class, 'getThirdDetails'])->name('sub_categories.details');
    Route::get('/delete-slider-image/{id}', [BlogController::class, 'deleteImage'])
        ->name('delete-slider-image');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

    Route::get('offices',[OfficeController::class,'index'])->name('offices.index');

});

//Route::group(['prefix' => 'admin'], function (){
//
//
//});

//Route::group(['prefix' => LaravelLocalization::setLocale()], function (){
//    Route::get('sigorta_qanunu', [HomeController::class,'sigorta_qanunu'])->name('sigorta_qanunu');
//    Route::get('dovlet_qulluqculari', [HomeController::class,'dovlet_qulluqculari'])->name('dovlet_qulluqculari');
//    Route::get('icbari_sigorta_qanun', [HomeController::class,'icbari_sigorta_qanun'])->name('icbari_sigorta_qanun');
//    Route::get('inzibati_xetalar_mecellesi', [HomeController::class,'inzibati_xetalar_mecellesi'])->name('inzibati_xetalar_mecellesi');
//    Route::get('tibbi_sigorta_qanun', [HomeController::class,'tibbi_sigorta_qanun'])->name('tibbi_sigorta_qanun');
//    Route::get('kasko_qanun', [HomeController::class,'kasko_qanun'])->name('kasko_qanun');
//
//    Route::get('/sitemap.xml', [SitemapController::class, 'sitemap']);
//    Route::get('/', [HomeController::class,'welcome'])->name('welcome');
//    Route::get('success',[HomeController::class,'success'])->name('success');
//    Route::get('{slug}', [HomeController::class,'dynamicPage'])->name('dynamic.page');
//    Route::post('submit', [HomeController::class,'submit'])->name('forms.submit');
//    Route::post('/contact_post',[HomeController::class,'contact_post'])->name('contact_post');
//});
