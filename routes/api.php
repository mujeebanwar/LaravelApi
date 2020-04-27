<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

/**
 * Api End Points For Buyers
 */
Route::resource('buyers','Buyer\BuyerController')->only('index','show');
Route::resource('buyers.transaction','Buyer\BuyerTransactionController')->only('index');
Route::get('buyers/{buyer}/products','Buyer\BuyerTransactionController@ShowProducts');
Route::get('buyers/{buyer}/sellers','Buyer\BuyerTransactionController@ShowSellers');
Route::get('buyers/{buyer}/categories','Buyer\BuyerTransactionController@ShowCategories');

/**
 * Api End Points For Sellers
 */

Route::resource('sellers','Seller\SellerController')->only('index','show');

/**
 * Api End Points For Categories
 */

Route::resource('categories','Category\CategoryController')->except('create','edit');
Route::resource('categories.products','Category\CategoryProductsController')->only('index');
Route::get('categories/{category}/sellers','Category\CategoryProductsController@showCategories');
Route::get('categories/{category}/transactions','Category\CategoryProductsController@showTransactions');
Route::get('categories/{category}/buyers','Category\CategoryProductsController@showBuyers');


/**
 * Api End Points For Products
 */

Route::resource('products','Product\ProductController')->only('index','show');

/**
 * Api End Points For Users
 */

Route::resource('users','User\UserController')->except('create','edit');

/**
 * Api End Points For Transactions
 */

Route::resource('transactions','Transaction\TransactionController')->only('index','show');
Route::resource('transactions.categories','Transaction\TransactionCategoryController')->only('index');
Route::get('transactions/{transaction}/seller','Transaction\TransactionCategoryController@ShowSeller');
