<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });




Route::post('/register',[UserController::class,'createUser']);
Route::post('/login',[UserController::class,'loginUser']);


// Route::middleware('auth:sanctum')->group(function () {

    Route::get('/products',[ProductController::class,'index'])->middleware('check.method:GET');
    Route::get('/products/{id}',[ProductController::class,'show'])->middleware('check.method:GET');
    Route::post('/products',[ProductController::class,'store'])->middleware('check.method:POST');
    Route::put('/products/{id}',[ProductController::class,'update'])->middleware('check.method:PUT');
    Route::delete('/products/{id}',[ProductController::class,'destroy'])->middleware('check.method:Delete');
    
// });