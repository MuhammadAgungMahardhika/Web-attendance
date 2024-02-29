<?php

use App\Http\Controllers\MainCompanyController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Models\MainCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::name('api')->group(function () {
    // user
    Route::get('users', [UserController::class, 'index']);
    Route::get('user/{id}', [UserController::class, 'index']);
    Route::post('user', [UserController::class, 'store']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::delete('user/{id}', [UserController::class, 'delete']);


    // role
    Route::get('roles', [RolesController::class, 'index']);
    Route::get('roles/{id}', [RolesController::class, 'index']);

    // Main company 
    Route::put('main-company/{id}', [MainCompanyController::class, 'update']);
    Route::get('roles/{id}', [RolesController::class, 'index']);
});
