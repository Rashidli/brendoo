<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AdvantageController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BasketItemController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ContactItemController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\HolidayBannerController;
use App\Http\Controllers\Api\InstagramController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\LoginBannerController;
use App\Http\Controllers\Api\LogoController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\NoticeController;
use App\Http\Controllers\Api\OnBoardingController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductMainController;
use App\Http\Controllers\Api\ReasonController;
use App\Http\Controllers\Api\ReturnProductController;
use App\Http\Controllers\Api\RuleController;
use App\Http\Controllers\Api\SeoController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\SocialController;
use App\Http\Controllers\Api\SpecialController;
use App\Http\Controllers\Api\StockNotificationController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TiktokController;
use App\Http\Controllers\Api\TopLineController;
use App\Http\Controllers\Api\TranslateController;
use App\Http\Controllers\Api\TranslationController;
use App\Http\Controllers\Api\VirtualTryOnController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [CustomerController::class,'register']);
Route::post('verifyEmail', [CustomerController::class,'verifyEmail']);
Route::post('login', [CustomerController::class,'login']);

Route::post('/login/google', [CustomerController::class, 'loginGoogle']);
Route::post('/register/google', [CustomerController::class, 'registerGoogle']);


Route::post('/virtual-try-on', [VirtualTryOnController::class, 'submitTryOn']);
Route::get('/virtual-try-on/{task_id}', [VirtualTryOnController::class, 'checkStatus']);

Route::group(['middleware' => 'setLocale'], function () {

    Route::get('banners' , [BannerController::class,'index']);
    Route::post('/password-reset/request', [CustomerController::class, 'requestPasswordReset']);
    Route::post('/password-reset/reset', [CustomerController::class, 'resetPassword']);
    Route::post('getProducts',[ProductController::class,'getProducts']);
    Route::post('subscribe',[SubscriptionController::class,'store']);
    Route::get('shops', [ShopController::class,'index']);
    Route::middleware(['auth:sanctum', 'check.blocked'])->group(function () {

        Route::post('/create-payment', [PaymentController::class, 'createPayment']);
        Route::post('/check-payment', [PaymentController::class, 'checkOrderPayment']);

        Route::post('contact', [ContactController::class,'store']);
        Route::post('/update', [CustomerController::class, 'update']);
        Route::post('/logout', [CustomerController::class, 'logout']);

        Route::post('/change-email/request', [CustomerController::class, 'requestEmailChange']);
        Route::post('/change-email/verify', [CustomerController::class, 'verifyEmailChange']);
        Route::post('/logout', [CustomerController::class, 'logout']);

        //comment
        Route::post('comment', [CommentController::class, 'store']);

        //basket
        Route::apiResource('basket_items', BasketItemController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::post('storeMultipleBasketItems', [BasketItemController::class,'storeMultipleBasketItems']);

        //order
        Route::post('storeOrder', [OrderController::class,'storeOrder']);
        Route::get('getOrders', [OrderController::class,'getOrders']);
        Route::get('getOrderItem/{id}', [OrderController::class,'getOrderItem']);
        Route::post('cancelOrder', [OrderController::class, 'cancelOrder']);
        Route::post('changeOrderAddress', [OrderController::class,'changeOrderAddress']);

        //address
        Route::get('getAddress', [AddressController::class,'index']);
        Route::post('storeOrUpdate', [AddressController::class, 'storeOrUpdate']);

        //favorites
        Route::get('/favorites', [FavoriteController::class, 'index']);
        Route::post('/favorites/toggleFavorite', [FavoriteController::class, 'toggleFavorite']);

        //notifications
        Route::get('notifications', [NoticeController::class,'index']);
        Route::put('read/notification', [NoticeController::class,'update']);

        //applyCoupon
        Route::post('applyCoupon' ,[OrderController::class,'applyCoupon']);

        //tracking products
        Route::post('track-product-view',[ProductController::class,'trackProductView']);
        Route::get('get-recently-viewed-products',[ProductController::class,'getRecentlyViewedProducts']);

        // İstifadəçi geri qaytarma tələbi göndərir
        Route::post('/returns', [ReturnProductController::class, 'store']);

        // İstifadəçinin geri qaytarma siyahısı
        Route::get('/returns', [ReturnProductController::class, 'index']);

        //Mənə bildir
        Route::post('notify-me', [StockNotificationController::class, 'store']);



//        Route::get('/districts/{cityId}', [LocationController::class, 'getDistricts']);
//        Route::get('/settlements/{districtId}', [LocationController::class, 'getSettlements']);

    });
//Şəhər rayon qəsəbə

    Route::get('/regions', [LocationController::class, 'getRegions']);
    Route::get('/search', [ProductController::class, 'search']);
    Route::get('/on-boardings', [OnBoardingController::class, 'index']);
    Route::get('/cities/{regionId}', [LocationController::class, 'getCities']);

    Route::get('/translates',[TranslateController::class,'translates']);
    Route::get('/translations', [TranslationController::class, 'index']);
    Route::get('categories', [CategoryController::class,'index']);
    Route::get('catalog_categories', [CategoryController::class,'catalog_categories']);
    Route::get('sub_categories', [CategoryController::class,'sub_categories']);
    Route::get('brands', [BrandController::class,'index']);
    Route::get('product_hero', [ProductMainController::class,'index']);
    Route::get('hero', [MainController::class,'index']);
    Route::get('advantages', [AdvantageController::class,'index']);
//    Route::get('rule', [RuleController::class,'index']);
    Route::get('socials', [SocialController::class,'index']);
    Route::get('products', [ProductController::class,'index']);
    Route::get('reasons', [ReasonController::class,'index']);
    Route::get('top_line', [TopLineController::class,'index']);
    Route::get('seo_pages', [SeoController::class,'index']);
    Route::get('instagrams', [InstagramController::class,'index']);
    Route::get('tiktoks', [TiktokController::class,'index']);
    Route::get('special', [SpecialController::class,'index']);
    Route::get('favicon', [LogoController::class,'favicon']);
    Route::get('logo', [LogoController::class,'logo']);
    Route::get('faqCategory', [FaqController::class,'faqCategory']);
    Route::get('faqs', [FaqController::class,'faqs']);
    Route::get('contact_items', [ContactItemController::class,'index']);
    Route::get('home_categories', [CategoryController::class,'home_categories']);
    Route::get('loginBanners', [LoginBannerController::class,'index']);
    Route::get('holidayBanners', [HolidayBannerController::class,'index']);
    Route::get('about', [AboutController::class,'index']);
    Route::get('filters', [FilterController::class,'index']);

    Route::get('productSingle/{slug}', [ProductController::class,'productSingle']);
    Route::get('product/{id}', [ProductController::class,'product']);
    Route::get('registerImage', [LogoController::class,'registerImage']);


    Route::get('pages', [DeliveryController::class,'pages']);

});
