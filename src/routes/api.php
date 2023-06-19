<?php

use App\Http\Controllers\TruckController;
use App\Http\Controllers\TruckSubunitController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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


Route::apiResource('/trucks', TruckController::class)
    ->missing(function (Request $request): JsonResponse {
        return response()->json(['error' => 'Provided id does not match any trucks.'], 404);
    });

Route::apiResource('/subunits', TruckSubunitController::class)
    ->missing(function (Request $request): JsonResponse {
        return response()->json(['error' => 'Provided id does not match any subunit entries.'], 404);
    });