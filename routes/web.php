<?php

use App\Http\Controllers\Admin\MenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\ResponseController;
use App\Http\Controllers\Admin\CouponReportsController;
use App\Http\Controllers\Admin\UserReportsController;
use App\Http\Controllers\Admin\SaleReportsController;
use App\Http\Controllers\Admin\BalanceReportsController;
use App\Http\Controllers\Admin\GlobalReportsController;
use App\Http\Controllers\Admin\ScoreController;
use App\Http\Controllers\Admin\RoleController;
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
    Route::get('/notificaciones', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notificaciones/{notification}/estadisticas', [NotificationController::class, 'stats'])->name('notifications.stats');

    // Menus, Roles y Permisos
    //Route::get('/menus', [MenuController::class, 'index'])->name('menus');
    Route::get('/menus-roles', [MenuController::class, 'roles'])->name('menus.roles');
    Route::resource('roles', RoleController::class, ['except' => ['store', 'update', 'destroy']]);


    // Users
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('users.create');
    Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');

    // Grupos
    Route::get('/grupos', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/grupos/crear', [GroupController::class, 'create'])->name('groups.create');
    Route::get('/grupos/{group}/editar', [GroupController::class, 'edit'])->name('groups.edit');
    Route::get('/grupos/{group}', [GroupController::class, 'show'])->name('groups.show');
    Route::get('/grupos/{group}/establecimientos/crear', [GroupController::class, 'store'])->name('groups.store');

    //Respuestas
    Route::get('/respuestas', [ResponseController::class, 'index'])->name('responses.index');

    //Calificaciones
    Route::get('/calificaciones', [ScoreController::class, 'scores'])->name('scores');

    //Reportes
    Route::get('/reportes/cupones/impresos', [CouponReportsController::class, 'printed'])->name('reports.coupons.printed');
    Route::get('/reportes/cupones/canjeados', [CouponReportsController::class, 'redeemed'])->name('reports.coupons.redeemed');
    Route::get('/reportes/cupones/ultimo-impreso', [CouponReportsController::class, 'lastPrinted'])->name('reports.coupons.last-printed');
    Route::get('/reportes/cupones/impresos-canjeados', [CouponReportsController::class, 'printedRedeemed'])->name('reports.coupons.printed-redeemed');
    Route::get('/reportes/cupones/detalle-canjes', [CouponReportsController::class, 'detailRedeemed'])->name('reports.coupons.detail-redeemed');
    Route::get('/reportes/cupones/historico', [CouponReportsController::class, 'printedRedeemedHistory'])->name('reports.coupons.printed-redeemed-history');

    Route::get('/reportes/usuarios/nuevos', [UserReportsController::class, 'newUsers'])->name('reports.users.new');
    Route::get('/reportes/usuarios/historico', [UserReportsController::class, 'history'])->name('reports.users.history');
    Route::get('/reportes/usuarios/actividad', [UserReportsController::class, 'activity'])->name('reports.users.activity'); //Agregar al menu y las vistas.

    Route::get('/reportes/ventas/detalle-ventas', [SaleReportsController::class, 'detailSales'])->name('reports.sales.detail');
    Route::get('/reportes/ventas/historico', [SaleReportsController::class, 'historySales'])->name('reports.sales.history');
    Route::get('/reportes/ventas/ventas', [SaleReportsController::class, 'sales'])->name('reports.sales.sales');

    Route::get('/reportes/saldo', [BalanceReportsController::class, 'balance'])->name('reports.balance');

    Route::get('/reportes/globales/redeems', [GlobalReportsController::class, 'redeems'])->name('reports.globals.redeems');
    Route::get('/reportes/globales/registers', [GlobalReportsController::class, 'registers'])->name('reports.globals.registers');


});
