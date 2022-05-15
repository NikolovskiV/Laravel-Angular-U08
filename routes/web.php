<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login',[AdminController::class, 'login'])->name('Admin.login');
Route::post('admin/login', [AuthController::class, 'login']);
Route::group([

    'middleware' => 'admin'

], function ($router) {

    Route::get('/admin/dashboard',[AdminController::class, 'dashboard'])->name('Admin.dashboard');
    
    Route::get('/admin/add-user',[AdminController::class, 'addUser'])->name('Admin.addUser');
    Route::get('/admin/edit-user/{id}',[AdminController::class, 'editUser'])->name('Admin.editUser');
    Route::post('/admin/save-user',[AdminController::class, 'saveUser'])->name('Admin.saveUser');
    Route::post('/admin/save-user/{id}',[AdminController::class, 'saveUser'])->name('Admin.updateUser');
    Route::get('/admin/user-list',[AdminController::class, 'userList'])->name('Admin.userList');
    Route::post('/admin/get-all-users',[AdminController::class, 'getAllUsers'])->name('Admin.getAllUsers');
    Route::post('/admin/delete-user/{id}',[AdminController::class, 'deleteUser'])->name('Admin.deleteUser');

    Route::get('/admin/logout',[AdminController::class, 'logout'])->name('Admin.logout');

});
