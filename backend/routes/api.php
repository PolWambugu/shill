<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\EmissionsController;
use App\Http\Controllers\WasteController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReportController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('suppliers', SupplierController::class);
    Route::apiResource('emissions', EmissionsController::class);
    Route::apiResource('waste', WasteController::class);
    Route::apiResource('resources', ResourceController::class);
    Route::get('/reports/summary', [ReportController::class, 'summary']);
});