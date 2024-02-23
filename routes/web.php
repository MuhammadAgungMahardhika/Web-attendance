<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// index side-menu
Route::get('/', function () {
    return view('index-vertical');
});
// index side-horizonta-menu
Route::get('/h', function () {
    return view('index-horizontal');
});
// index side-horizonta-menu
Route::get('/c', function () {
    return view('index-1-column');
});
