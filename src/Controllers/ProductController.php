<?php

namespace App\Controllers;

use App\Kernel\Controller;
use App\Kernel\Exceptions\ViewNotFoundException;

class ProductController extends Controller
{
    /**
     * @throws ViewNotFoundException
     */
    public function index(): void
    {
        $this->render('products');
    }

    public function compare(): void
    {
        $this->render('compare');
    }
}