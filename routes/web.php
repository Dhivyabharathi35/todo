<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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


Route::get('/', [TodoController::class, 'index'])->name('todos');
Route::get('/todo', [TodoController::class, 'create'])->name('todo');

Route::post('/todo', [TodoController::class, 'store'])->name('todo');

Route::get('/todo-edit/{id}', [TodoController::class, 'edit'])->name('todo-edit');

Route::put('/todo-update/{id}', [TodoController::class, 'update'])->name('todo-update');

Route::delete('/todo-delete/{id}', [TodoController::class, 'destroy'])->name('todo-delete');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
