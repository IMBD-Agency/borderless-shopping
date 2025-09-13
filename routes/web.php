<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
//route group frontend
Route::group(['as' => 'frontend.'], function () {
    Route::get('/', [FrontendController::class, 'index'])->name('index');
});

//route group backend
Route::group(['prefix' => 'dashboard', 'as' => 'backend.', 'middleware' => ['auth', 'check.user.status']], function () {
    Route::get('/', [BackendController::class, 'dashboard'])->name('dashboard');

    // Profile route for authenticated user
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changeOwnPassword'])->name('profile.change-password');
    Route::put('/profile/update-picture', [ProfileController::class, 'updateOwnProfilePicture'])->name('profile.update-picture');

    //users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/change-password/{id}', [UserController::class, 'changePassword'])->name('users.change-password');
    Route::put('/users/update-profile-picture/{id}', [UserController::class, 'updateProfilePicture'])->name('users.update-profile-picture');
    Route::get('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    //settings
    Route::get('/settings', [BackendController::class, 'settings'])->name('settings');
});
