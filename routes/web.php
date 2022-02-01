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
    Route::post('/task/{task}', [TasksController::class, 'update'])->name('up.Delete');

    Route::post('/check-task/{task}', [TasksController::class, 'store'])->name('status-check');
    Route::get('/search-task/', [TasksController::class, 'search'])->name('task.search');


    Route::get('/guzzler/', [\App\Http\Controllers\GuzzlerController::class, 'index'])->name('posts');
    Route::get('/posts/', [\App\Http\Controllers\GuzzlerController::class, 'fetchPosts'])->name('posts.all');
    Route::post('/posts/', [\App\Http\Controllers\GuzzlerController::class, 'createPost'])->name('posts.add');
    Route::put('/post-update/{post}', [\App\Http\Controllers\GuzzlerController::class, 'updatePost'])->name('posts.update');
    Route::delete('/posts/{post}', [\App\Http\Controllers\GuzzlerController::class, 'deletePost'])->name('posts.delete');

});
//http://to-do.appp/post-update/1
