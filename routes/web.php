<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GoogleController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});

Route::resource('stores', StoreController::class);
Route::resource('tables', TableController::class);//->middleware(['auth','admin']);
Route::resource('items', ItemController::class)->middleware(['auth','admin']);
Route::get('items/import', [ItemController::class, 'showImportQuantityForm'])->name('items.import')->middleware(['auth','admin']);
Route::post('items/import', [ItemController::class, 'importQuantity'])->name('items.import.post')->middleware(['auth','admin']);
Route::resource('products', ProductController::class)->middleware(['auth','admin']);
Route::post('items/import-quantity', [ItemController::class, 'importQuantityFromProducts'])->name('items.import.quantity');
Route::get('stores/{store}/tables', [StoreController::class, 'tables'])->name('stores.tables');
Route::get('tables/{table}/orders', [TableController::class, 'orders'])->name('tables.orders');
Route::get('customer/orders/create', [CustomerOrderController::class, 'create'])->name('customer.orders.create');
Route::post('customer/orders', [CustomerOrderController::class, 'store'])->name('customer.orders.store');
Route::get('orders/{order}/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
Route::post('orders/{order}/complete', [OrderController::class, 'completeCheckout'])->name('orders.completeCheckout');
Route::resource('orders', OrderController::class);
Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback.index');
Route::get('feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/stores/{store}/tables/create', [TableController::class, 'create'])->name('tables.create.for.store');
Route::get('/tables/create', [TableController::class, 'createGeneral'])->name('tables.create');
Route::get('/tables/{table}/orders/create', [OrderController::class, 'createForTable'])->name('orders.create.for.table');
Route::get('/orders/create', [OrderController::class, 'createGeneral'])->name('orders.create');
// Route for the checkout page for a specific table
Route::get('/tables/{table}/checkout', [TableController::class, 'checkout'])->name('tables.orders.checkout');
Route::post('/tables/{table}/checkout', [TableController::class, 'processCheckout'])->name('tables.orders.checkout.process');
Route::get('/orders/{order}/orderMore', [OrderController::class, 'orderMore'])->name('orders.orderMore');
Route::post('/orders/{order}/addItems', [OrderController::class, 'addItems'])->name('orders.addItems');


Route::patch('/tables/{table}/update-status', [TableController::class, 'updateStatus'])->name('tables.updateStatus');
Route::patch('/tables/{table}/unorder', [TableController::class, 'unorder'])->name('tables.unorder');
Route::get('google-autocomplete', [GoogleController::class, 'index']);


require __DIR__.'/auth.php';
