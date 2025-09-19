<?php

namespace App\UseCases;

use App\Model\Product;

class GetProductCategoriesUseCase
{
    public static function execute()
    {
        return Product::getCategories();
    }
}