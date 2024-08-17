<?php

use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ContractStatusController;
use App\Http\Controllers\Api\ContractTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CustomerController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::apiResource('permissions',PermissionController::class);

Route::apiResource('users',UserController::class);

Route::apiResource('contract_status',ContractStatusController::class);

Route::apiResource('contract_type',ContractTypeController::class);

Route::apiResource('customers', CustomerController::class);

Route::apiResource('contracts', ContractController::class);

