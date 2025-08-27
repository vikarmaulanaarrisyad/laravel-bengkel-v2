<?php

use App\Http\Controllers\{
    CategoryController,
    ChartController,
    CheckoutController,
    DashboardController,
    OrderController,
    PaymentController,
    PermissionController,
    PermissionGroupController,
    ProductController,
    ReviewController,
    RoleController,
    SettingController,
    TrackingController,
    UserController
};
use App\Http\Controllers\Front\FrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('front.index');
// MINI CART

Route::get('/product/{slug}', [FrontController::class, 'detailProduct'])->name('front.detail_product');
Route::group(
    ['middleware' => ['auth', 'verified']],
    function () {
        Route::post('/cart/data/store/{id}', [ChartController::class, 'addToCart'])->name('cart.store');
        Route::get('/product/mini/cart', [ChartController::class, 'addMiniCart'])->name('cart.mini');
        Route::get('/minicart/product-remove/{rowId}', [ChartController::class, 'removeMiniCart'])->name('cart.remove_mini');
        Route::get('/remove-mycart/{rowId}', [ChartController::class, 'removeMyCart']);
        Route::get('/cart-increment/{rowId}', [ChartController::class, 'incrementMyCart']);
        Route::get('/cart-decrement/{rowId}', [ChartController::class, 'decrementMyCart']);
        Route::get('/cart-update/{rowId}/{quantity}', [ChartController::class, 'updateQuantity'])->name('cart.update');

        Route::get('/checkout', [CheckoutController::class, 'index'])->name('front.checkout_index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('front.checkout_store');
        Route::get('/checkout/history', [CheckoutController::class, 'history'])->name('front.checkout_history');
        Route::get('/order-details/{orderId}', [OrderController::class, 'getOrderDetails'])->name('order.details');
        Route::get('/payment', [PaymentController::class, 'pay'])->name('payment.pay');

        Route::post('/get-snap-token', [PaymentController::class, 'getSnapToken'])->name('get-snap-token');
        Route::post('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.paymentSuccess');
    }
);
// Dashboard bisa diakses tanpa verifikasi email
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['role_or_permission:Dashboard Index']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::group(['middleware' => ['permission:User Index']], function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/ajax/users/role_search', 'roleSearch')->name('users.role_search');
            Route::get('/users/data', 'data')->name('users.data');
            Route::get('/users', 'index')->name('users.index');
            Route::get('/users/{users}/detail', 'detail')->name('users.detail');
            Route::get('/users/{users}', 'edit')->name('users.edit');
            Route::put('/users/{users}/update', 'update')->name('users.update');
            Route::post('/users', 'store')->name('users.store');
            Route::delete('/users/{users}/destroy', 'destroy')->name('users.destroy');
            // Route::delete('/user/profile', 'show')->name('profile.show');
        });
    });

    Route::group(['middleware' => ['permission:Role Index']], function () {
        Route::controller(RoleController::class)->group(function () {
            Route::get('/role/data', 'data')->name('role.data');
            Route::get('/role', 'index')->name('role.index');
            Route::get('/role/{role}/detail', 'detail')->name('role.detail');
            Route::get('/role/{role}', 'edit')->name('role.edit');
            Route::put('/role/{role}/update', 'update')->name('role.update');
            Route::post('/role', 'store')->name('role.store');
            Route::delete('/role/{role}/destroy', 'destroy')->name('role.destroy');
        });
    });

    Route::group(['middleware' => ['permission:Permission Index']], function () {
        Route::controller(PermissionController::class)->group(function () {
            Route::get('/permissions/data', 'data')->name('permission.data');
            Route::get('/permissions', 'index')->name('permission.index');
            Route::get('/permissions/{permission}/detail', 'detail')->name('permission.detail');
            Route::get('/permissions/{permission}', 'edit')->name('permission.edit');
            Route::put('/permissions/{permission}/update', 'update')->name('permission.update');
            Route::post('/permissions', 'store')->name('permission.store');
            Route::delete('/permissions/{permission}/destroy', 'destroy')->name('permission.destroy');
        });
    });

    Route::group(['middleware' => ['permission:Group Permission Index']], function () {
        Route::controller(PermissionGroupController::class)->group(function () {
            Route::get('/permissiongroups/data', 'data')->name('permissiongroups.data');
            Route::get('/permissiongroups', 'index')->name('permissiongroups.index');
            Route::get('/permissiongroups/{permissionGroup}/detail', 'detail')->name('permissiongroups.detail');
            Route::get('/permissiongroups/{permissionGroup}', 'edit')->name('permissiongroups.edit');
            Route::put('/permissiongroups/{permissionGroup}/update', 'update')->name('permissiongroups.update');
            Route::post('/permissiongroups', 'store')->name('permissiongroups.store');
            Route::delete('/permissiongroups/{permissionGroup}/destroy', 'destroy')->name('permissiongroups.destroy');
        });
    });

    Route::group(['middleware' => ['permission:Pengaturan Index']], function () {
        Route::controller(SettingController::class)->group(function () {
            Route::get('/setting', 'index')->name('setting.index');
            Route::put('/setting/{setting}', 'update')->name('setting.update');
        });
    });

    Route::group(['middleware' => ['permission:Category Index']], function () {
        Route::get('/category/data', [CategoryController::class, 'data'])->name('category.data');
        Route::get('/category/search', [CategoryController::class, 'search'])->name('category.search');
        Route::resource('/category', CategoryController::class)->except('create', 'edit');
    });

    Route::group(['middleware' => ['permission:Product Index']], function () {
        Route::get('/products/data', [ProductController::class, 'data'])->name('products.data');
        Route::resource('/products', ProductController::class)->except('create', 'edit');
    });

    Route::group(['middleware' => ['permission:Orders Index']], function () {
        Route::get('/orders/data', [OrderController::class, 'data'])->name('orders.data');
        Route::resource('/orders', OrderController::class)->except('create', 'edit');
        Route::post('/orders/update-resi', [OrderController::class, 'updateResi'])->name('orders.update.resi');
    });

    Route::get('/orders/{id}/download', [OrderController::class, 'generatePdf'])->name('orders.download');
});

Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/track', [TrackingController::class, 'track'])->name('tracking.track');
Route::post('/tracking/ajax', [TrackingController::class, 'ajaxTracking'])->name('tracking.ajax');
Route::post('/tracking/simulate', [TrackingController::class, 'simulate'])->name('tracking.simulate');
Route::get('/orders/{order}/fake-resi', [OrderController::class, 'showFakeResiForm'])->name('orders.fake-resi.form');
Route::post('/orders/fake-resi', [OrderController::class, 'createFakeResiAndTracking'])->name('orders.fake-resi.create');


Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
