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

Route::get('/', function (Request $request) {
    return response()->json(['Welcome to the Zip Codes Service!'], 200);
});

Route::get('/api', function (Request $request) {
    return response()->json(['Welcome to the Zip Codes Service!'], 200);
});

Route::group(['prefix' => 'api/zip-codes'], function($router) {
    Route::get('/{zipCode}', [\App\Http\Controllers\ZipCodeController::class, 'index'])->name('zip-codes');
});
