<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\DocumentTypeController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => 'jwt.verify'], function(){
    Route::get('document-types', [DocumentTypeController::class, 'list']);
    Route::post('document-types/create', [DocumentTypeController::class, 'create']);
    Route::post('users/create', [UserController::class, 'create']);
    Route::post('job-offers/create', [JobOfferController::class, 'create']);
    Route::get('job-offers', [JobOfferController::class, 'list']);
});



