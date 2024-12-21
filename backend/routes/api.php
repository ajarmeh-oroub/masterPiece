<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthPharmacyController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\PharmacyController;
use App\Http\Controllers\Api\ProductContrller;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|-------------------------------------------------------------------------- 
| API Routes
|-------------------------------------------------------------------------- 
| 
| Here is where you can register API routes for your application. These 
| routes are loaded by the RouteServiceProvider and all of them will 
| be assigned to the "api" middleware group. Make something great!
| 
*/

// Authenticated route example (this is optional for registration)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Register route for user registration
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout' , [AuthController::class , 'logout']);
});
Route::POST('/register' , [AuthController::class, 'SignUp']);
Route::POST('/login' , [AuthController::class, 'login']);
Route::put('/user/{id}/update' , [UserController::class , 'update']);
Route::get('/user/{id}/show' , [UserController::class , 'show']);
Route::put('user/{id}/address' , [UserController::class , 'updateAddress']);



Route::get('/products' , [ProductContrller::class , 'index']);
Route::get('/product/{id}' , [ProductContrller::class , 'show']);
Route::POST('/products/create', [ProductContrller::class, 'storeproduct']);
Route::PUT('/products/{id}/update', [ProductContrller::class, 'update']);
Route::PUT('/products/delete/{id}', [ProductContrller::class, 'toggleStatus']);
Route::get('/newArrivals' , [ProductContrller::class , 'getNewArrivals']);
Route::get('/getBestSeller' , [ProductContrller::class , 'getBestSeller']);
Route::get('/getSales', [ProductContrller::class , 'getSales'] );



Route::get('/blogs' , [BlogController::class , 'index']);
Route::post('/blog/create/{id}' , [BlogController::class , 'store']);
Route::put('/blog/update/{id}' , [BlogController::class , 'update']);
Route::delete('/blog/delete/{id}', [BlogController::class , 'destroy']);

Route::get('/pharmacies' , [PharmacyController::class , 'index']);
Route::get('/pharmacy/{id}' , [PharmacyController::class , 'show']);
Route::put('/pharmacy/{id}/update', [PharmacyController::class, 'update']);
Route::put('/pharmacy/{id}' , [PharmacyController::class , 'deactivate']);
Route::put('/pharmacy/{id}/delivers' , [PharmacyController::class , 'toggleDelivery']);


Route::get('/subcategories' , [SubCategoryController::class , 'index']);

Route::get('/brands' , [BrandController::class , 'index']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/pharmacy/logout', [AuthPharmacyController::class, 'logout']);
});
Route::post('/pharmacy/register' ,[AuthPharmacyController::class , 'SignUp']);
Route::post('/pharmacy/login' , [AuthPharmacyController::class , 'login']);




