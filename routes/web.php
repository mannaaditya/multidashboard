<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;


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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[AuthController::class,'loadLogin']);
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/logout',[AuthController::class,'logout']);

Route::group(['prefix' =>'Admin','middleware'=>['web','isAdmin']],function(){
    Route::get('/dashboard',[AdminController::class,'dashboard']);

 });
Route::group(['prefix' =>'User','middleware'=>['web','isUser']],function(){
    Route::get('/dashboard',[UserController ::class,'dashboard']);

});
