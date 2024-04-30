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
    Route::get('/forgot-password', function () {
        return view('auth/forgot-password');
    });
});


// Menu
Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware('auth');
Route::get('/users', [PageController::class, 'user'])->middleware(['auth', 'check.role:1,2']);
Route::get('/main-company', [PageController::class, 'mainCompany'])->middleware(['auth', 'check.role:1']);
Route::get('/main-company/{id}', [PageController::class, 'mainCompanyMap'])->middleware(['auth', 'check.role:1']);

// Route::put('main-company-update/{id}', [MainCompanyController::class, 'update'])->middleware(['auth', 'check.role:1']);
Route::get('/outsource-company', [PageController::class, 'outsourceCompany'])->middleware(['auth', 'check.role:1,2']);
Route::get('/shift', [PageController::class, 'shift'])->middleware(['auth', 'check.role:1,2']);
Route::get('/attendance', [PageController::class, 'attendance'])->middleware('auth');
Route::get('/account', [PageController::class, 'account'])->middleware('auth');

// mobile webview
Route::get('/mobile/attendance/{user_id}', [PageController::class, 'getMobileAttendanceHistory']);
