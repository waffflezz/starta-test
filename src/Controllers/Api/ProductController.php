<?php

namespace App\Controllers\Api;

use App\Kernel\Controller;
use App\Requests\ProductRequest;

class ProductController extends Controller
{
    public function upload()
    {
        $this->setRequest(ProductRequest::createFromGlobals());
        $request = $this->getRequest();
        if (!$request->validate()) {
            $this->json([
                'status' => 'error',
                'errors' => $request->errors()
            ], 422);
        }
    }
}