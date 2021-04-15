<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\Todo\TodoController;
use App\Http\Controllers\Todo\TodoTaskController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('verify-email', [AuthController::class, 'verifyEmail'])->name('verify-email');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');

    Route::prefix('me')->group(function () {
        Route::get('', [MeController::class, 'index'])->name('me');
        Route::put('', [MeController::class, 'update'])->name('me.update');
    });

    Route::prefix('todos')->group(function () {
        Route::get('', [TodoController::class, 'index'])->name('todos');
        Route::get('{todo}', [TodoController::class, 'show'])->name('todo.show');
        Route::post('', [TodoController::class, 'store'])->name('todo.store');
        Route::put('{todo}', [TodoController::class, 'update'])->name('todo.update');
        Route::delete('{todo}', [TodoController::class, 'destroy'])->name('todo.destroy');
        Route::post('{todo}/tasks', [TodoController::class, 'createTask'])->name('todo.createTask');
    });

    Route::prefix('tasks')->group(function () {
        Route::put('{todoTask}', [TodoTaskController::class, 'update'])->name('task.update');
        Route::delete('{todoTask}', [TodoTaskController::class, 'destroy'])->name('task.destroy');
    });
});

