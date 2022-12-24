<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AspirationController;

Route::post("admin/add", [AdminController::class, "store"]);


Route::prefix('/aspiration')
  ->controller(AspirationController::class)
  ->group(function () {
    Route::get('/', 'index');
    Route::get('/detail/{id}', 'show');
    Route::get('/status/{status}', 'showByStatus');
    Route::post('/add', 'store');
    Route::post('/update/{id}', 'update');
  });
