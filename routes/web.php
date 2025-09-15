<?php

use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\SuperAdmin\ManagePermissionController;
use App\Http\Controllers\SuperAdmin\ManageRoleController;

use App\Http\Controllers\SuperAdmin\ManageUserController;
use App\Http\Controllers\SuperAdmin\PermissionRouteController;
use App\Http\Controllers\SuperAdmin\RoleRedirectController;
use Illuminate\Support\Facades\Route;



// Login routes
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    // Resource standar
    Route::resource('permissions', ManagePermissionController::class);
    Route::resource('roles', ManageRoleController::class);
    Route::resource('users', ManageUserController::class);

    // Role Redirect & Permission Route dalam satu controller unik
    Route::get('permission-routes', [PermissionRouteController::class, 'index'])->name('permission-routes.index');

    // RoleRedirect
    Route::post('role-redirects/store', [PermissionRouteController::class, 'storeRoleRedirect'])->name('role-redirects.store');
    Route::put('role-redirects/{roleRedirect}/update', [PermissionRouteController::class, 'updateRoleRedirect'])->name('role-redirects.update');
    Route::delete('role-redirects/{roleRedirect}/delete', [PermissionRouteController::class, 'destroyRoleRedirect'])->name('role-redirects.destroy');

    // PermissionRoute
    Route::post('permission-routes/store', [PermissionRouteController::class, 'storePermissionRoute'])->name('permission-routes.store');
    Route::put('permission-routes/{permissionRoute}/update', [PermissionRouteController::class, 'updatePermissionRoute'])->name('permission-routes.update');
    Route::delete('permission-routes/{permissionRoute}/delete', [PermissionRouteController::class, 'destroyPermissionRoute'])->name('permission-routes.destroy');
});

// Route tambahan untuk ambil permissions per user (AJAX)
Route::get('superadmin/users/{id}/permissions', [ManageUserController::class, 'getPermissions'])->name('superadmin.users.permissions');


Route::middleware(['auth', 'dynamic.permission'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('users', AdminController::class)->except(['index']);
});


Route::middleware(['auth', 'dynamic.permission'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('users', AdminController::class)->except(['index']);
});


Route::middleware(['auth', 'dynamic.permission'])->prefix('sellers')->name('sellers.')->group(function () {

    Route::resource('sellers', SellerController::class);
});



