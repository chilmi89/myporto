<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuperAdmin\ManageRoleController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



// Login routes
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/dashboard', [SuperAdminController::class, 'index'])
    ->name('dashboard')->middleware(['auth'])
    ;



Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/role-permission', [SuperAdminController::class, 'index'])->name('role.permission.index');

    Route::post('/role-permission/role', [SuperAdminController::class, 'createRole'])->name('role.create');
    Route::post('/role-permission/permission', [SuperAdminController::class, 'createPermission'])->name('permission.create');

    Route::post('/role-permission/assign', [SuperAdminController::class, 'givePermissionToRole'])->name('role.assign.permission');
    Route::post('/role-permission/revoke', [SuperAdminController::class, 'revokePermissionFromRole'])->name('role.revoke.permission');
});



Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::resource('roles', ManageRoleController::class);
});
