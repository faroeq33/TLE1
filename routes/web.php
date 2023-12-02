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
    Route::get('/admin/user/overview', [AdminController::class, 'view_user'])->name('admin.view_user');

    Route::get('/admin/user/create', [AdminController::class, 'view_create_user'])->name('admin.view_create_user');
    Route::post('/admin/user/create/post', [AdminController::class, 'create_user'])->name('admin.create_user');

    Route::get('/admin/user/edit/{user}', [AdminController::class, 'view_edit_user'])->name('admin.view_edit_user');
    Route::patch('/admin/user/edit/put/{user}', [AdminController::class, 'edit_user'])->name('admin.edit_user');

    Route::delete('/admin/user/delete/{user}', [AdminController::class, 'delete_user'])->name('admin.delete_user');
});
