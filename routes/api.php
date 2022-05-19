<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    // Route::post('login', 'AuthController@login')->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register/{id}', [AuthController::class, 'register']);
    Route::post('savelist', [AuthController::class, 'savelist']);
    Route::post('get-item-user', [AuthController::class, 'getItemByUser']);
    Route::post('create-list', [AuthController::class, 'createList']);
    Route::post('get-list-name', [AuthController::class, 'getListNames']);
    Route::post('save-item', [AuthController::class, 'saveItem']);
    Route::post('item-list-byid', [AuthController::class, 'getitembylistbyid']);
    Route::post('item-delete', [AuthController::class, 'itemDelete']);
});
