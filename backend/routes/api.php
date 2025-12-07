<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmissionsController; // <-- UNCOMMENT THESE
use App\Http\Controllers\WasteController;     // <-- UNCOMMENT THESE
use App\Http\Controllers\ResourceController;  // <-- UNCOMMENT THESE
use App\Http\Controllers\SupplierController;  // <-- UNCOMMENT THESE
use App\Http\Controllers\ReportController;    // <-- UNCOMMENT THESE
use App\Http\Controllers\VerifyEmailController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->group(function () { // <-- UNCOMMENT THIS GROUP START
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::apiResource('emissions', EmissionsController::class);
    Route::apiResource('waste', WasteController::class);
    Route::apiResource('resources', ResourceController::class);
    Route::apiResource('suppliers', SupplierController::class);
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
     ->name('verification.verify');
    
    Route::get('/reports/summary', [ReportController::class, 'summary']);
}); // <-- UNCOMMENT THIS GROUP END

Route::get('/dashboard/mock', function (Illuminate\Http\Request $request) {

    $filter = $request->query('filter', 'daily');

    $data = [
        'daily' => [
            ['label' => 'Mon', 'value' => 10],
            ['label' => 'Tue', 'value'=> 12],
            ['label' => 'Wed', 'value' => 9],
            ['label' => 'Thu', 'value' => 14],
            ['label' => 'Fri', 'value' => 11],
            ['label' => 'Sat', 'value' => 13],
            ['label' => 'Sun', 'value' => 15],
        ],

        'weekly' => [
            ['label' => 'Week 1', 'value' => 60],
            ['label' => 'Week 2', 'value' => 54],
            ['label' => 'Week 3', 'value' => 70],
            ['label' => 'Week 4', 'value' => 65],
        ],

        'monthly' => [
            ['label' => 'Jan', 'value' => 220],
            ['label' => 'Feb', 'value' => 180],
            ['label' => 'Mar', 'value' => 260],
            ['label' => 'Apr', 'value' => 250],
            ['label' => 'May', 'value' => 300],
            ['label' => 'Jun', 'value' => 270],
        ],

        'yearly' => [
            ['label' => '2020', 'value' => 2400],
            ['label' => '2021', 'value' => 2600],
            ['label' => '2022', 'value' => 3100],
            ['label' => '2023', 'value' => 2800],
            ['label' => '2024', 'value' => 3300],
        ]
    ];

    return response()->json([
        'co2' => 4800,
        'waste' => 1250,
        'water' => 8000,
        'suppliers' => 3,
        'chart' => $data[$filter]
    ]);
});
