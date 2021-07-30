<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WaiterOrderController;
use App\Http\Controllers\CookerOrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\EmployeeController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
// Route::get('/test', function() {
//     return phpinfo();
// });

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('/clients', ClientController::class);
    Route::resource('/tables', TableController::class);
    Route::resource('/menus', MenuController::class);
});

Route::group(['middleware' => ['auth:sanctum', 'role:administrator']], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::resource('/employees', EmployeeController::class);
    /*
     * request exemple with filters in get orders
     * http://localhost:8000/api/orders?table_id=1&date=2021-07-28T12:00:00-03:00&dateFilter=month&client_id=1
    */
    Route::resource('/orders', OrderController::class);
});

Route::group(['middleware' => ['auth:sanctum', 'role:waiter']], function () {
    Route::resource('/waiterOrders', WaiterOrderController::class);
});

Route::group(['middleware' => ['auth:sanctum', 'role:cooker']], function () {
    Route::resource('/cookerOrders', CookerOrderController::class);
});
