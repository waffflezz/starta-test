<?php

namespace App\UseCases;

use App\Model\Product;

class GetProductsWithMediansUseCase
{
    public static function execute(array $filters = [], array $sort = [], int $page = 1, int $perPage = 12): array
    {
        $result = Product::getPaginated($filters, $sort, $page, $perPage);
        $categoryMedians = Product::getCategoryMedians();

        return [
            'data' => $result['data'],
            'pagination' => $result['pagination'],
            'categoryMedians' => $categoryMedians,
        ];
    }
}