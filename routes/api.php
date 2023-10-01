<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('info', [AuthController::class, 'info']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::group(['prefix' => 'todo'], function(){
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('get', [TodoController::class, 'getTodoList']);
        Route::post('add', [TodoController::class, 'createTodo']);
        Route::get('get_id/{id}', [TodoController::class, 'getTodoId']);
        Route::delete('delete/{id}', [TodoController::class, 'deleteTodo']);
        Route::put('update/{id}', [TodoController::class, 'updateTodo']);
    });
});