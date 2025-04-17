<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

// Frontend için ana sayfa
Route::get('/', function () {
    return view('welcome');
});

// API endpointleri
Route::get('/todos', [TodoController::class, 'index']);
Route::post('/todos', [TodoController::class, 'store']);
Route::put('/todos/{todo}', [TodoController::class, 'update']);
Route::delete('/todos/{todo}', [TodoController::class, 'destroy']);