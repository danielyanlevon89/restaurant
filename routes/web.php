<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BkashController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\MenuController as AdminMenuController;
use App\Http\Controllers\admin\ChefController as AdminChefController;
use App\Http\Controllers\admin\OrderController as AdminOrderController;
use App\Http\Controllers\admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\admin\ReservationController as AdminReservationController;
use App\Http\Controllers\admin\CustomizeController as AdminCustomizeController;
use App\Http\Controllers\admin\BannerController as AdminBannerController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\admin\CouponController as AdminCouponController;
use App\Http\Controllers\admin\ChargeController as AdminChargeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("/", 'App\Http\Controllers\HomeController@index');

Route::post("/register/confirm",'App\Http\Controllers\HomeController@register')->name('register/confirm');
Route::get("/redirects",'App\Http\Controllers\HomeController@redirects');

#Route::get("/menu",'App\Http\Controllers\MenuController@menu');
Route::get('/menu/{type?}', [MenuController::class, 'menu'])->name('menu');

Route::get('/trace-my-order', [ShipmentController::class, 'trace'])->name('trace-my-order');


Route::get('/my-order', [ShipmentController::class, 'my_order'])->name('my-order');


Route::get("/rate/{id}", [HomeController::class, 'rate'])->name('rate');


Route::get("/top/rated", [HomeController::class, 'top_rated'])->name('top/rated');



Route::get("edit/rate/{id}", [HomeController::class, 'edit_rate'])->name('edit/rate');



Route::post("coupon/apply", [ShipmentController::class, 'coupon_apply'])->name('coupon/apply');





Route::get("delete/rate", [HomeController::class, 'delete_rate'])->name('delete/rate');



Route::get("/rate/confirm/{value}", [HomeController::class, 'store_rate'])->name('rate.confirm');


Route::get("/cart", [CartController::class, 'index'])->name('cart');


Route::post('/menu/{product}', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/shipment', [ShipmentController::class, 'shipment'])->name('shipment');
Route::post('/confirm_order', [ShipmentController::class, 'send'])->name('confirm_order');

Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/reserve/confirm', [HomeController::class, 'reservation_confirm'])->name('reserve.confirm');

Route::post('/trace/confirm', [ShipmentController::class, 'trace_confirm'])->name('trace.confirm');



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('ssl/pay', [BkashController::class, 'ssl']);
Route::get('ssl/pay2', [BkashController::class, 'ssl2']);

Route::group(['middleware' => ['customAuth']], function () {

    // Payment Routes for bKash
    Route::post('bkash/get-token', 'BkashController@getToken')->name('bkash-get-token');
    Route::post('bkash/create-payment', 'BkashController@createPayment')->name('bkash-create-payment');
    Route::post('bkash/execute-payment', 'BkashController@executePayment')->name('bkash-execute-payment');
    Route::get('bkash/query-payment', 'BkashController@queryPayment')->name('bkash-query-payment');
    Route::post('bkash/success', 'BkashController@bkashSuccess')->name('bkash-success');

    // Refund Routes for bKash
    Route::get('bkash/refund', 'BkashRefundController@index')->name('bkash-refund');

    Route::post('bkash/refund', 'BkashRefundController@refund')->name('bkash-refund');

});


// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


// Admin start Route

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

Route::get('/menus', [AdminMenuController::class, 'index'])->name('admin.menus');
Route::get('/menu/add', [AdminMenuController::class, 'add'])->name('admin.menu.add');
Route::post('/menu/create', [AdminMenuController::class, 'create'])->name('admin.menu.create');
Route::get('/menu/{id}/edit/', [AdminMenuController::class, 'edit'])->name('admin.menu.edit');
Route::get('/menu/{id}/delete/', [AdminMenuController::class, 'delete'])->name('admin.menu.delete');
Route::put('/menu/{id}/update', [AdminMenuController::class, 'update'])->name('admin.menu.update');

Route::get('/chefs', [AdminChefController::class, 'index'])->name('admin.chefs');
Route::get('/chef/add', [AdminChefController::class, 'add'])->name('admin.chef.add');
Route::post('/chef/create', [AdminChefController::class, 'create'])->name('admin.chef.create');
Route::get('/chef/{id}/edit/', [AdminChefController::class, 'edit'])->name('admin.chef.edit');
Route::get('/chef/{id}/delete/', [AdminChefController::class, 'delete'])->name('admin.chef.delete');
Route::put('/chef/{id}/update', [AdminChefController::class, 'update'])->name('admin.chef.update');

Route::get('/orders/process', [AdminOrderController::class, 'process'])->name('admin.orders.process');
Route::get('/orders/cancel', [AdminOrderController::class, 'cancel'])->name('admin.orders.cancel');
Route::get('/orders/complete', [AdminOrderController::class, 'complete'])->name('admin.orders.complete');
Route::get('/orders/location', [AdminOrderController::class, 'location'])->name('admin.orders.location');
Route::get('/orders/incomplete', [AdminOrderController::class, 'incomplete'])->name('admin.orders.incomplete');

Route::get('/invoice/details/{id}', [AdminInvoiceController::class, 'details'])->name('admin.invoice.details');
Route::post('/invoice/approve/{id}', [AdminInvoiceController::class, 'approve'])->name('admin.invoice.approve');
Route::get('/invoice/cancel/{id}', [AdminInvoiceController::class, 'cancel'])->name('admin.invoice.cancel');
Route::get('/invoice/complete/{id}', [AdminInvoiceController::class, 'complete'])->name('admin.invoice.complete');
Route::post('/invoice/location/edit', [AdminInvoiceController::class, 'edit_order_location'])->name('admin.invoice.location');

Route::get('/reservation', [AdminReservationController::class, 'reservation'])->name('admin.reservation');

Route::get('/customize/edit', [AdminCustomizeController::class, 'edit'])->name('admin.customize.edit');
Route::post('/customize/save', [AdminCustomizeController::class, 'save'])->name('admin.customize.save');

Route::get('/banners', [AdminBannerController::class, 'index'])->name('admin.banners');
Route::get('/banner/add', [AdminBannerController::class, 'add'])->name('admin.banner.add');
Route::post('/banner/create', [AdminBannerController::class, 'create'])->name('admin.banner.create');
Route::get('/banner/{id}/delete', [AdminBannerController::class, 'delete'])->name('admin.banner.delete');
Route::get('/banner/{id}/edit', [AdminBannerController::class, 'edit'])->name('admin.banner.edit');
Route::put('/banner/{id}/update', [AdminBannerController::class, 'update'])->name('admin.banner.update');

Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
Route::get('/user/add', [AdminUserController::class, 'add'])->name('admin.user.add');
Route::post('/user/create', [AdminUserController::class, 'create'])->name('admin.user.create');
Route::get('/user/{id}/delete', [AdminUserController::class, 'delete'])->name('admin.user.delete');
Route::get('/user/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.user.edit');
Route::put('/user/{id}/update', [AdminUserController::class, 'update'])->name('admin.user.update');

Route::get('/coupons', [AdminCouponController::class, 'index'])->name('admin.coupons');
Route::get('/coupon/add', [AdminCouponController::class, 'add'])->name('admin.coupon.add');
Route::post('/coupon/create', [AdminCouponController::class, 'create'])->name('admin.coupon.create');
Route::get('/coupon/{id}/delete', [AdminCouponController::class, 'delete'])->name('admin.coupon.delete');
Route::get('/coupon/{id}/edit', [AdminCouponController::class, 'edit'])->name('admin.coupon.edit');
Route::put('/coupon/{id}/update', [AdminCouponController::class, 'update'])->name('admin.coupon.update');

Route::get('/charges', [AdminChargeController::class, 'index'])->name('admin.charges');
Route::get('/charge/add', [AdminChargeController::class, 'add'])->name('admin.charge.add');
Route::post('/charge/create', [AdminChargeController::class, 'create'])->name('admin.charge.create');
Route::get('/charge/{id}/delete', [AdminChargeController::class, 'delete'])->name('admin.charge.delete');
Route::get('/charge/{id}/edit', [AdminChargeController::class, 'edit'])->name('admin.charge.edit');
Route::put('/charge/{id}/update', [AdminChargeController::class, 'update'])->name('admin.charge.update');



});
