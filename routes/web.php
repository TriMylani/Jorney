<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);

// API Endpoints untuk Form & Inputan
Route::post('/api/todos', [DashboardController::class, 'storeTodo']);
Route::put('/api/todos/{id}', [DashboardController::class, 'updateTodo']);
Route::delete('/api/todos/{id}', [DashboardController::class, 'destroyTodo']);

Route::post('/api/habits', [DashboardController::class, 'storeHabit']);