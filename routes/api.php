<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("admin/add", [AdminController::class, "store"]);
