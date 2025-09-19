<?php

namespace App\UseCases;

use App\Model\Product;

class GetProductsUseCase
{
    public static function execute(array $filters = [], array $sort = [], int $page = 1, int $perPage = 12): array
    {
        $result = Product::getPaginated($filters, $sort, $page, $perPage);

        return [
            'status' => 'success',
            'data' => $result['data'],
            'pagination' => [
                'total' => $result['pagination']['total'],
                'page' => $page,
                'perPage' => $perPage,
                'pages' => ceil($result['pagination']['total'] / $perPage),
            ],
        ];
    }
}