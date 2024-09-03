<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminvController;
use App\Http\Controllers\ClientvController;
use App\Http\Controllers\AdminForgotPasswordController;
use App\Http\Controllers\AdminResetPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ClientForgotPasswordController;
use App\Http\Controllers\ClientResetPasswordController;
use App\Http\Controllers\ClientEmailController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;




//product
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/edit/{pid}', [ProductController::class, 'edit'])->name('products.edit');
Route::post('/products/update/{pid}', [ProductController::class, 'update'])->name('products.update');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
Route::delete('/products/destroy/{pid}', [ProductController::class, 'destroy'])->name('products.destroy');

//category
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/edit/{cid}', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/update/{cid}', [CategoryController::class, 'update'])->name('categories.update');
Route::get('/categories/destroy/{cid}', [CategoryController::class, 'destroy'])->name('categories.destroy');

//Admin Routes
Route::get('admin/register', [AdminAuthController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::get('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

//Admin Forgot Password Routes
Route::get('/admin/password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/password/email', [EmailController::class, 'sendEmail'])->name('admin.password.email');
Route::get('admin/password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('admin/password/reset', [AdminResetPasswordController::class, 'reset'])->name('admin.password.update');

//Client  Routes
Route::get('client/register', [ClientAuthController::class, 'client_showRegistrationForm'])->name('client.register');
Route::post('client/register', [ClientAuthController::class, 'client_register'])->name('client.register.submit');
Route::get('client/login', [ClientAuthController::class, 'client_showLoginForm'])->name('client.login');
Route::post('client/login', [ClientAuthController::class, 'client_login'])->name('client.login.submit');
Route::get('client/logout', [ClientAuthController::class, 'client_logout'])->name('client.logout');

//Client Forgot Password Routes
Route::get('password/reset', [ClientForgotPasswordController::class, 'client_showLinkRequestForm'])->name('client.password.request');
Route::post('password/email', [ClientEmailController::class, 'sendEmail'])->name('client.password.email');
Route::get('client/password/reset/{token}', [ClientResetPasswordController::class, 'client_showResetForm'])->name('client.password.reset');
Route::post('password/reset', [ClientResetPasswordController::class, 'reset'])->name('client.password.update');

//admin view 
Route::resource('admin', AdminvController::class);
//client view 
Route::resource('client', ClientvController::class);

//View Cart
Route::post('add-to-cart/{pid}', [ProductController::class, 'addToCart'])->name('client.addToCart');
Route::get('cart', [ProductController::class, 'viewCart'])->name('cart');
Route::delete('remove-from-cart/{id}', [ProductController::class, 'removeFromCart'])->name('client.removeFromCart');
Route::put('update-cart/{id}', [ProductController::class, 'updateCart'])->name('client.updateCart');

//address route
Route::get('/addresses', [AddressController::class, 'index'])->name('client.address');
Route::get('/addresses/create', [AddressController::class, 'create'])->name('client.address.create');
Route::post('/addresses/store', [AddressController::class, 'store'])->name('client.address.store');
Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('client.address.destroy');
Route::post('/payment/deliver', 'AddressController@deliverToAddress')->name('client.address.deliver');
//checkout route
Route::get('/checkout', [AddressController::class, 'checkout'])->name('checkout');

//Payment routes
Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/payment/response', [PaymentController::class, 'paymentResponse'])->name('payment.response');
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/failure', [PaymentController::class, 'paymentFailure'])->name('payment.failure');


//order_Display route

Route::get('/orders', [OrderController::class, 'index'])->name('orders.show');
Route::get('/create-order', [OrderController::class, 'createOrder']);
Route::get('clients/{id}/orders', [ClientvController::class, 'showOrders'])->name('client.orders');

//tracking shipping status
Route::get('/order/track/{orderId}', [OrderController::class, 'trackOrder'])->name('order.track');;
