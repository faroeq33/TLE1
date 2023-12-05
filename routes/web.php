<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => ['auth']], function() {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Tour overview and detail page
    Route::get('/tour/overview', [App\Http\Controllers\TourController::class, 'index'])->name('overview');
    Route::get('/tour/detail/{id}', [App\Http\Controllers\TourController::class, 'detail'])->name('detail');

    //Livestream
    Route::get('livestream/{login_code}', [App\Http\Controllers\TourController::class, 'livestreamConnect'])->name('livestream');

});

Route::group(['middleware' => ['check.admin']], function() {

    Route::get('/admin/user/overview', [AdminController::class, 'view_user'])->name('admin.view_user');

    Route::get('/admin/user/create', [AdminController::class, 'view_create_user'])->name('admin.view_create_user');
    Route::post('/admin/user/create/post', [AdminController::class, 'create_user'])->name('admin.create_user');

    Route::get('/admin/user/edit/{user}', [AdminController::class, 'view_edit_user'])->name('admin.view_edit_user');
    Route::patch('/admin/user/edit/put/{user}', [AdminController::class, 'edit_user'])->name('admin.edit_user');

    Route::delete('/admin/user/delete/{user}', [AdminController::class, 'delete_user'])->name('admin.delete_user');

});
