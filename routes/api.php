<?php

use App\Http\Controllers\Api\v1\CustomersController;
use App\Http\Controllers\Api\v1\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




// api/v1

Route::group(['prefix'=> 'v1',
                          'namespace'=> 'App\Http\Controllers\Api\v1',
                          'middleware' => 'auth:sanctum' ], function () {


    Route::apiResource('customers',CustomersController::class);
    Route::apiResource('invoices',InvoiceController::class);

    // bulk store customers
    Route::post('/customers/bulk', [CustomersController::class, 'bulkStore']);
    // bulk store invoices
    Route::post('/invoices/bulk', [InvoiceController::class, 'bulkStore']);


});
