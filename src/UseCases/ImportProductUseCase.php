<?php

namespace App\UseCases;

use App\Exceptions\ProductValidationException;
use App\Model\Product;
use App\Services\FileParserService;
use App\Services\ProductValidatorService;

class ImportProductUseCase
{
    /**
     * @throws ProductValidationException
     */
    public static function execute(string $filePath, string $mimeType): array
    {
        $rows = FileParserService::parse($filePath, $mimeType);

        [$validRows, $errors] = ProductValidatorService::validate($rows);

        if (!empty($errors)) {
            throw new ProductValidationException($errors);
        }

        $rowCount = Product::insertMany($validRows);

        return [
            'products_insert' => $rowCount,
        ];
    }
}