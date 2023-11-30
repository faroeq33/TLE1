<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//No log-in needed routes
    //Needs to be above Auth::routes(); otherwise users need to log-in in order to log in
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();
//Tour overview and detail page
    Route::get('/tour/overview', [App\Http\Controllers\TourController::class, 'index'])->name('overview');
    Route::get('/tour/detail/{id}', [App\Http\Controllers\TourController::class, 'detail'])->name('detail');

//Livestream
    Route::get('livestream/{login_code}', [App\Http\Controllers\TourController::class, 'livestreamConnect'])->name('livestream');

//Admin
    Route::group(['middleware' => ['check.admin']], function() {
        Route::get('/admin/user', [AdminController::class, 'view_user'])->name('admin.user');

        Route::post('/admin/create/{user}', [AdminController::class, 'create'])->name('admin.create');

        Route::put('/admin/edit/{user}', [AdminController::class, 'edit'])->name('admin.edit');

        Route::delete('/admin/delete/{user}', [AdminController::class, 'delete'])->name('admin.delete');
    });
