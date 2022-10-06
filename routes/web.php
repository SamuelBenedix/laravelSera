<?php

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

Route::get('/', [UserController::class,'index']);
Route::get('/add',[UserController::class,'add']);
Route::post('/processAdd',[UserController::class,'processAdd'])->name('processAddUser');
Route::get('/edit/{id}',[UserController::class,'edit']);
Route::post('/processEdit',[UserController::class,'processEdit'])->name('processEditUser');
Route::get('/delete/{id}',[UserController::class,'delete'])->name('processDeleteUser');

