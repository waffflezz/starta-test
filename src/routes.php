<?php

use App\Controllers\MainController;
use App\Kernel\Route;

return [
    Route::get('/', [MainController::class, 'index'])
];