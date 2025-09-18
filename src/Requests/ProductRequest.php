<?php

namespace App\Requests;

use App\Kernel\Request;

class ProductRequest extends Request
{
    public function rules(): array
    {
        return [
            'file' => 'required|file',
        ];
    }
}