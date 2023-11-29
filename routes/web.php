<?php

use App\Http\Controllers\AdminController;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    // All routes that require a login
});

Route::group(['middleware' => ['check.admin']], function() {
    Route::get('/admin/user', [AdminController::class, 'view_user'])->name('admin.user');

    Route::post('/admin/create/{user}', [AdminController::class, 'create'])->name('admin.create');

    Route::put('/admin/edit/{user}', [AdminController::class, 'edit'])->name('admin.edit');

    Route::delete('/admin/delete/{user}', [AdminController::class, 'delete'])->name('admin.delete');
});
