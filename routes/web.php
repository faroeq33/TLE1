<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::redirect('/register', '/login');

Route::get('livestream/kijker/{login_code}', [TourController::class, 'viewerLivestream'])->name('kijker_livestream');

Route::group(['middleware' => ['auth']], function() {

    //Tour overview and detail page
    Route::get('/', [TourController::class, 'overview'])->name('overview');
    Route::get('/tour/detail/{id}', [TourController::class, 'detail'])->name('detail');

    //Livestream
    Route::get('livestream/gids/{login_code}', [TourController::class, 'guideLivestream'])->name('gids_livestream');
    Route::get('/livestream/ipcar/{login_code}', [TourController::class, 'ipCarStream'])->name('ip_car_livestream');

});

Route::group(['middleware' => ['check.admin']], function() {
    //Users
    Route::get('/admin/user/overview', [AdminController::class, 'view_user'])->name('admin.view_user');

    Route::get('/admin/user/create', [AdminController::class, 'view_create_user'])->name('admin.view_create_user');
    Route::post('/admin/user/create/post', [AdminController::class, 'create_user'])->name('admin.create_user');

    Route::get('/admin/user/edit/{user}', [AdminController::class, 'view_edit_user'])->name('admin.view_edit_user');
    Route::patch('/admin/user/edit/{user}', [AdminController::class, 'edit_user'])->name('admin.edit_user');

    Route::delete('/admin/user/delete/{user}', [AdminController::class, 'delete_user'])->name('admin.delete_user');

    //Tours
    Route::get('/admin/tour/create', [AdminController::class, 'view_create_tour'])->name('admin.view_create_tour');
    Route::post('/admin/tour/create/post', [AdminController::class, 'create_tour'])->name('admin.create_tour');

    Route::get('/admin/tour/edit/{tour}', [AdminController::class, 'view_edit_tour'])->name('admin.view_edit_tour');
    Route::patch('/admin/tour/edit/{tour}', [AdminController::class, 'edit_tour'])->name('admin.edit_tour');

    Route::delete('/admin/tour/delete/{tour}', [AdminController::class, 'delete_tour'])->name('admin.delete_tour');
});
