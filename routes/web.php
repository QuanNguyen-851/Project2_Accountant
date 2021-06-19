<?php

use App\Http\Controllers\ComponentsController;
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

//dashboad
Route::get('/', function () {
    return view('dashboard');
});
//components
Route::get('buttons', [ComponentsController::class, 'buttons']);
Route::get('grid', [ComponentsController::class, 'grid']);
