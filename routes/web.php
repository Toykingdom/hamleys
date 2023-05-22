<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GiftRedemptionController;
use App\Http\Controllers\CustomerController;


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

Route::get('/', function () {
    return redirect('/login');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');

// })->name('dashboard');

// Route::get('/search/',  [SearchController::class,'search'])->name('search');


// print more cards


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/search/{term?}',  [SearchController::class,'search'])->name('search');
    Route::any('/customer/print-cards/{customer_code}',  [CustomerController::class,'addChildren'])->name('print_cards');
    Route::any('/customer/print/{customer_code}/{name}',  [CustomerController::class,'printCard'])->name('print');
    Route::get('/customer/update/{customer_code}',  [CustomerController::class,'updateCustomer'])->name('update_customer');
    Route::get('/gifts/redeem/{customer_code}',  [GiftRedemptionController::class,'redeem'])->name('redeem_gifts');
    Route::get('/gifts/report/{month?}',  [GiftRedemptionController::class,'report'])->name('redemption_report');
});
