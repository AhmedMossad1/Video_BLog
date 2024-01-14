<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VideoController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/video',[VideoController::class,'index']);
Route::get('/video/{id}',[VideoController::class,'show']);
Route::post('/video',[VideoController::class,'store']);
Route::post('/video/{id}',[VideoController::class,'update']);
Route::post('/videos/{id}',[VideoController::class,'destory']);
