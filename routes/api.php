<?php

declare(strict_types=1);

use App\Http\Controllers\OrganizationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// API routes with API key middleware
Route::middleware('api.key')->group(function () {
    // Organizations routes
    Route::get('/organizations/building/{buildingId}', [OrganizationController::class, 'getByBuilding']);
    Route::get('/organizations/activity/{activityId}', [OrganizationController::class, 'getByActivity']);
    Route::get('/organizations/radius', [OrganizationController::class, 'getByRadius']);
    Route::get('/organizations/search', [OrganizationController::class, 'searchByName']);
    Route::get('/organizations/{id}', [OrganizationController::class, 'getById']);
    
    // Buildings routes
    Route::get('/buildings', [OrganizationController::class, 'getBuildings']);
    Route::get('/buildings/coordinates', [OrganizationController::class, 'getBuildingsWithCoordinates']);
    
    // Test route without Form Request
    Route::get('/test', function () {
        return response()->json(['message' => 'API is working!']);
    });
    

}); 