<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\EstudentController;
use App\Http\Controllers\TacherController;
use App\Http\Controllers\ModuleTeacherController;

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

Route::prefix('/')->group(function () {

    Route::apiResource('modules', ModuleController::class);
    Route::apiResource('estudents', EstudentController::class);
    Route::apiResource('tachers', TacherController::class);
    Route::apiResource('module-teachers', ModuleTeacherController::class);

    });