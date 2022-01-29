<?php

use App\Http\Controllers\TasksController;
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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [\App\Http\Controllers\TasksController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard',[TasksController::class, 'index'])->name('dashboard');

    Route::get('/task',[TasksController::class, 'add']);
    Route::post('/task',[TasksController::class, 'create']);

    Route::get('/task/{task}', [TasksController::class, 'edit']);
    Route::post('/task/{task}', [TasksController::class, 'update']);
    Route::post('/task/{task}', [TasksController::class, 'store'])->name('status-check');
});
