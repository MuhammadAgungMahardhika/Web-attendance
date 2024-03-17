<?php

use App\Http\Controllers\MainCompanyController;
use App\Http\Controllers\OutsourceCompanyController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__ . '/auth.php';

// Error pages
Route::get('error/403', function () {
    return view('error/403');
});

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('auth/login');
    });
    Route::get('/login', function () {
        return view('auth/login');
    });
});

// Menu
Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware('auth');
Route::get('/users', [PageController::class, 'user'])->middleware(['auth', 'check.role:1,2']);
Route::get('/main-company', [PageController::class, 'mainCompany'])->middleware(['auth', 'check.role:1']);
Route::put('main-company/{id}', [MainCompanyController::class, 'update']);
Route::get('/outsource-company', [PageController::class, 'outsourceCompany'])->middleware(['auth', 'check.role:1,2']);
Route::get('/shift', [PageController::class, 'shift'])->middleware(['auth', 'check.role:1,2']);
Route::get('/attendance', [PageController::class, 'attendance'])->middleware('auth');
