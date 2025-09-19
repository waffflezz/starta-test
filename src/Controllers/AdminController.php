<?php

namespace App\Controllers;

use App\Kernel\Controller;
use App\Kernel\Exceptions\ViewNotFoundException;

class AdminController extends Controller
{
    /**
     * @throws ViewNotFoundException
     */
    public function index(): void {
        $this->render('admin');
    }
}