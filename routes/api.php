<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::apiResource('products', ProductController::class)
        ->only('index','show')
        ->middleware('throttle:api');

Route::apiResource('categories', CategoryController::class)
        ->only('index')
        ->middleware('throttle:api');