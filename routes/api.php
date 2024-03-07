<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\MainCompanyController;
use App\Http\Controllers\OutsourceCompanyController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ShiftController;
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
    Route::get('users', [UserController::class, 'get']);
    Route::get('user/{id}', [UserController::class, 'get']);
    Route::post('user', [UserController::class, 'store']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::delete('user/{id}', [UserController::class, 'delete']);


    // role
    Route::get('roles', [RolesController::class, 'get']);
    Route::get('roles/{id}', [RolesController::class, 'get']);

    // Main company 
    Route::get('main-company', [MainCompanyController::class, 'get']);
    Route::get('main-company/{id}', [MainCompanyController::class, 'get']);
    Route::post('main-company', [MainCompanyController::class, 'store']);
    Route::put('main-company/{id}', [MainCompanyController::class, 'update']);
    Route::delete('main-company/{id}', [MainCompanyController::class, 'delete']);

    // Outsource company 
    Route::get('outsource-company', [OutsourceCompanyController::class, 'get']);
    Route::get('outsource-company/{id}', [OutsourceCompanyController::class, 'get']);
    Route::post('outsource-company', [OutsourceCompanyController::class, 'store']);
    Route::put('outsource-company/{id}', [OutsourceCompanyController::class, 'update']);
    Route::delete('outsource-company/{id}', [OutsourceCompanyController::class, 'delete']);

    // Shift  
    Route::get('shift', [ShiftController::class, 'get']);
    Route::get('shift/{id}', [ShiftController::class, 'get']);
    Route::post('shift', [ShiftController::class, 'store']);
    Route::put('shift/{id}', [ShiftController::class, 'update']);
    Route::delete('shift/{id}', [ShiftController::class, 'delete']);

    // Attendance  
    Route::get('attendance', [AttendanceController::class, 'get']);
    Route::get('attendance/{id}', [AttendanceController::class, 'get']);
    Route::post('attendance-by-date', [AttendanceController::class, 'getAttendanceByDate']);
    Route::get('attendance-by-date/{date}', [AttendanceController::class, 'getAttendanceByDate']);
    Route::get('attendance-by-user/{id}', [AttendanceController::class, 'getAttendanceByUserId']);
    Route::post('attendance', [AttendanceController::class, 'store']);
    Route::put('attendance/{id}', [AttendanceController::class, 'update']);
    Route::delete('attendance/{id}', [AttendanceController::class, 'delete']);
})->middleware('auth');
