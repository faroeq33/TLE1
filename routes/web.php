<?php

use Illuminate\Support\Facades\Auth;
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

//No log-in needed routes

Auth::routes();

//login
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Tour overview and detail page
Route::get('/overview', [App\Http\Controllers\TourController::class, 'index'])->name('overview');
Route::get('detail/{id}', [App\Http\Controllers\TourController::class, 'detail'])->name('detail');

//Livestream
Route::get('livestream/{login_code}', [App\Http\Controllers\TourController::class, 'livestreamConnect'])->name('livestream');
