<?php

use App\Http\Controllers\Admin\MenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\ResponseController;
use App\Http\Controllers\Admin\CouponReportsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Fortify routes
require_once __DIR__ . '/fortify.php';

Route::group(['middleware' => ['auth']], function(){

    //Dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Notificaciones
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

    // Menus
    Route::get('/menus', [MenuController::class, 'index'])->name('menus');
    Route::get('/menus-roles', [MenuController::class, 'roles'])->name('menus.roles');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

    // Grupos
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::get('/groups/{group}/show', [GroupController::class, 'show'])->name('groups.show');
    Route::get('/groups/{group}/stores/create', [GroupController::class, 'store'])->name('groups.store');

    //Respuestas
    Route::get('/responses', [ResponseController::class, 'index'])->name('responses.index');

    //Reportes
    Route::get('/reports/coupons/printed', [CouponReportsController::class, 'printed'])->name('reports.coupons.printed');
});
