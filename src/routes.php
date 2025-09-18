<?php

use App\Controllers\Api\ProductController;
use App\Kernel\Route;

return [
    Route::get('/', function () {
       echo "Hello World!";
    }),
    Route::post('/api/upload', [ProductController::class, 'upload'])
];