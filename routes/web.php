<?php

use App\Http\Controllers\ComponentsController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\LoginController;

use App\Http\Controllers\subfee;
use App\Http\Middleware\CheckBlock;

use App\Http\Middleware\CheckLoged;
use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Route;

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

//check login
Route::middleware([CheckLogin::class])->group(function(){

    //Check block
    Route::middleware([CheckBlock::class])->group(function(){
        //fee
        Route::resource('fee',FeeController::class);
        //logout
        Route::get('/logout',[LoginController::class, 'logout'])->name('logout');
        //add Count
        Route::get('/count',[FeeController::class, 'addcount'])->name('count');
        Route::get('/subcount',[subfee::class, 'addcount'])->name('subcount');
        //sub fee
        Route::resource('subfee',subfee::class);
        //change password
        Route::get('/changepass',[LoginController::class, 'changepass'])->name('changepass');
        Route::post('/changepassprocess',[LoginController::class,'changepasswordprocess'])->name('changepasswordprocess');
    });

});
//check loged
Route::middleware([CheckLoged::class])->group(function(){
    //login
    Route::get('/',[LoginController::class,'index'])->name('login');
    Route::post('/process',[LoginController::class, 'process'])->name('process');
});
//components
Route::get('buttons', [ComponentsController::class, 'buttons']);
Route::get('grid', [ComponentsController::class, 'grid']);

