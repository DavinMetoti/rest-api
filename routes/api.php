<?php

use App\Http\Controllers\Api\MonthlyTransactionController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SalesOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/monthly-transactions', [MonthlyTransactionController::class, 'getMonthlyTransactions']);
Route::get('/monthly-transactions/targets-and-transactions', [MonthlyTransactionController::class, 'getMonthlyTargetsAndTransactions']);
Route::get('/monthly-sales-performance', [MonthlyTransactionController::class, 'getMonthlySalesPerformance']);

Route::post('/customers', [CustomerController::class, 'store']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::patch('/customers/{id}', [CustomerController::class, 'update']);

Route::post('/sales-orders', [SalesOrderController::class, 'store']);
