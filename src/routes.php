<?php

use App\Controllers\AdminController;
use App\Controllers\Api\ProductController;
use App\Kernel\Route;

return [
    Route::get('/admin', [AdminController::class, 'index']),
    Route::get('/products', [\App\Controllers\ProductController::class, 'index']),
    Route::get('/compare', [\App\Controllers\ProductController::class, 'compare']),

    Route::post('/api/upload', [ProductController::class, 'upload']),
    Route::get('/api/products', [ProductController::class, 'index']),
    Route::get('/api/products/categories', [ProductController::class, 'categories']),
];