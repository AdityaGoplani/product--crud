<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
    return view('welcome');
});
 Route::get('products',[ProductController::class,'index']);
 Route::get('add-product',[ProductController::class,'create']);
 Route::post('add-product',[ProductController::class,'store']);
 Route::get('edit-product/{id}',[ProductController::class,'edit']);
 Route::put('update-profuct/{id}',[ProductController::class,'update']);
 Route::delete('delete-product/{id}',[ProductController::class,'destroy']);

 Route::post('products/importData',[ProductController::class,'importData'])->name('products/importData');
 
 // Route::post('products/importData','ProductController@importData')->name('products/importData');