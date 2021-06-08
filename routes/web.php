<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function(){

    //Dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Menus
    Route::get('/menus', [MenuController::class, 'index'])->name('menus');
    Route::get('/menus-roles', [MenuController::class, 'roles'])->name('menus.roles');

    // Users
    Route::resource('users', UserController::class, ['except' => ['store', 'update', 'destroy']]);

});
