<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ AuthController::class, 'getLoggedUser']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    //Employee APIs
    Route::post('/capture-employee', [ EmployeeController::class, 'captureEmployee']);
    Route::get('/get-employees', [ EmployeeController::class, 'getEmployees']);
    Route::get('/get-employee', [ EmployeeController::class, 'getEmployee']);
    Route::post('/update-employee', [ EmployeeController::class, 'updateEmployee']);

    //Client APIs
    Route::post('/capture-client', [ ClientController::class, 'captureClient']);
    Route::get('/get-clients', [ ClientController::class, 'getClients']);
    Route::get('/get-client', [ ClientController::class, 'getClient']);
    Route::post('/update-client', [ ClientController::class, 'updateClient']);

    //Asset APIs
    Route::post('/capture-asset', [ AssetController::class, 'captureAsset']);
    Route::get('/get-assets', [ AssetController::class, 'getAssets']);
    Route::get('/get-asset', [ AssetController::class, 'getAsset']);
    Route::post('/update-asset', [ AssetController::class, 'updateAsset']);
});
