<?php

namespace App\Controllers;

use App\Kernel\Controller;
use App\Kernel\Exceptions\ViewNotFoundException;

class MainController extends Controller
{
    /**
     * @throws ViewNotFoundException
     */
    public function index(): void {
        $this->render("main");
    }
}