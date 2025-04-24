<?php

use App\Http\Controllers\DataHierarchyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserHierarchyController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [DataHierarchyController::class, 'index']);
Route::get('/hierarchy', [DataHierarchyController::class, 'index']);
