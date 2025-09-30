<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
//route group frontend
Route::group(['as' => 'frontend.'], function () {
    Route::get('/', [FrontendController::class, 'index'])->name('index');
    Route::post('/order-request', [FrontendController::class, 'orderRequest'])->name('order-request');
    Route::get('/get-sub-cities', [FrontendController::class, 'getSubCities'])->name('get-sub-cities');
    Route::get('/orders/{slug}', [FrontendController::class, 'orderRequestInvoice'])->name('order-request.invoice');
    Route::get('/orders/{slug}/invoice', [FrontendController::class, 'orderRequestInvoiceDownload'])->name('order-request.invoice.download');
    Route::get('/thank-you/{tracking_number}', [FrontendController::class, 'thankYou'])->name('thank-you');
    Route::get('/track-order', [FrontendController::class, 'trackOrder'])->name('track-order');
    Route::post('/track-order', [FrontendController::class, 'trackOrderSubmit'])->name('track-order.submit');
    Route::get('/get-csrf-token', [FrontendController::class, 'getCsrfToken'])->name('get-csrf-token');
});

// User Dashboard Routes
Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth']], function () {
    Route::get('/dashboard', [FrontendController::class, 'userDashboard'])->name('dashboard');
    Route::get('/profile', [FrontendController::class, 'userProfile'])->name('profile');
    Route::put('/profile/update', [FrontendController::class, 'updateUserProfile'])->name('profile.update');
    Route::post('/profile/change-password', [FrontendController::class, 'changeUserPassword'])->name('profile.change-password');
    Route::put('/profile/update-picture', [FrontendController::class, 'updateUserProfilePicture'])->name('profile.update-picture');
    Route::get('/orders', [FrontendController::class, 'userOrders'])->name('orders');
    Route::get('/orders/{slug}', [FrontendController::class, 'userOrderDetails'])->name('orders.show');
});

//route group backend
Route::group(['prefix' => 'dashboard', 'as' => 'backend.', 'middleware' => ['auth', 'check.user.status', 'check.user.role']], function () {
    Route::get('/', [BackendController::class, 'dashboard'])->name('dashboard');

    //orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/show/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/edit/{id}', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/update/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::put('/orders/update-status/{id}', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/orders/delete/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('/orders/{id}/send-invoice', [OrderController::class, 'sendInvoice'])->name('orders.send-invoice');

    // payments
    Route::get('/orders/{id}/payments/create', [OrderController::class, 'createPayment'])->name('orders.payments.create');
    Route::post('/orders/{id}/payments', [OrderController::class, 'storePayment'])->name('orders.payments.store');
    Route::get('/orders/{id}/payments', [OrderController::class, 'listPayments'])->name('orders.payments.index');
    Route::delete('/orders/payments/{paymentId}', [OrderController::class, 'destroyPayment'])->name('orders.payments.destroy');

    // Profile route for authenticated user
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changeOwnPassword'])->name('profile.change-password');
    Route::put('/profile/update-picture', [ProfileController::class, 'updateOwnProfilePicture'])->name('profile.update-picture');

    //users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/change-password/{id}', [UserController::class, 'changePassword'])->name('users.change-password');
    Route::put('/users/update-profile-picture/{id}', [UserController::class, 'updateProfilePicture'])->name('users.update-profile-picture');
    Route::get('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    //settings
    Route::get('/settings', [BackendController::class, 'settings'])->name('settings');
    Route::post('/settings/contact', [BackendController::class, 'updateContact'])->name('settings.contact.update');
    Route::post('/settings/social-media', [BackendController::class, 'updateSocialMedia'])->name('settings.social-media.update');

    // reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/delete/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    //debug routes
    Route::get('/debug', [BackendController::class, 'debug'])->name('debug');
});
