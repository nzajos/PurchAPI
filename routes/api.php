<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\PurchaserController; 
use App\Http\Controllers\api\ProductPurchaseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes of this application are registered. These
| routes are loaded by the RouteServiceProvider and are grouped into 3 categories (User, Product, and Purchaser)
|
*/
 

Route::group([
    'prefix' => 'user'
], function () {
    Route::post('login', 'LoginController@login');
    Route::post('signup', 'LoginController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'LoginController@logout');
        Route::get('user', 'LoginController@user');
    });
});

//to group all products route

Route::group([
    'prefix' => 'product'
], function () {
    
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('store', [ProductController::class,'store']); 
        Route::get('/productlist', [ProductController::class,'index']); 
    });
});



//to group all purchase routes
Route::group([
    'prefix' => 'purchaser'
], function () { 
    
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('store', [PurchaserController::class,'store']); 
        Route::get('/purchaserlist', [PurchaserController::class,'index']); 
        Route::get('/{purchaser_id}/product', [ProductPurchaseController::class,'show']);
    });
});

//to group all purchase routes
Route::group([
    'prefix' => 'purchaser_product'
], function () { 
     

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('store', [ProductPurchaseController::class,'store']); 
        Route::get('/purchaserlist', [ProductPurchaseController::class,'index']);   
    });
});
 


 
