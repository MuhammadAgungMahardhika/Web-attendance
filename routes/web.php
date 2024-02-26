<?php

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
Route::get('/main-company', function () {
    return view('pages/main-company');
})->middleware('auth');
Route::get('/outsource-company', function () {
    return view('pages/outsource-company');
})->middleware('auth');
