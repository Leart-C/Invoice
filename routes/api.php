<?php

use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\PaymentController;

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function (){
    Route::get('/clients',[ClientController::class, 'index']);
    Route::get('/clients/{client}',[ClientController::class, 'show']);

    Route::get('/invoices', [InvoiceController::class, 'index']);
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show']);

    Route::post('/invoices/{invoice}/payments', [PaymentController::class, 'store']);

    Route::get('/dashboard', [DashboardController::class, 'index']);
});