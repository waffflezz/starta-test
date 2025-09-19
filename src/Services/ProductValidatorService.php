<?php

namespace App\Services;

class ProductValidatorService
{
    public static function validate(array $rows): array
    {
        $errors = [];
        $validRows = [];

        foreach ($rows as $i => $row) {
            if (array_filter($errors, fn($e) => $e['row'] === $i)) {
                continue;
            }

            if (!isset($row['id']) || !is_numeric($row['id'])) {
                $errors[] = ['row' => $i, 'field' => 'id', 'message' => 'id должно быть числом'];
            }

            if (!isset($row['name']) || !is_string($row['name'])) {
                $errors[] = ['row' => $i, 'field' => 'name', 'message' => 'name должно быть строкой'];
            }

            if (!isset($row['category']) || !is_string($row['category'])) {
                $errors[] = ['row' => $i, 'field' => 'category', 'message' => 'category должно быть строкой'];
            }

            if (!isset($row['price']) || !is_numeric($row['price'])) {
                $errors[] = ['row' => $i, 'field' => 'price', 'message' => 'price должно быть числом'];
            }

            if (!isset($row['stock']) || !is_numeric($row['stock'])) {
                $errors[] = ['row' => $i, 'field' => 'stock', 'message' => 'stock должно быть числом'];
            }

            if (!isset($row['rating']) || !is_numeric($row['rating'])) {
                $errors[] = ['row' => $i, 'field' => 'rating', 'message' => 'rating должно быть числом'];
            }

            if (!isset($row['created_at']) || strtotime($row['created_at']) === false) {
                $errors[] = ['row' => $i, 'field' => 'created_at', 'message' => 'created_at должно быть корректной датой'];
            }

            if (!array_filter($errors, fn($e) => $e['row'] === $i)) {
                $validRows[] = $row;
            }
        }

        return [$validRows, $errors];
    }
}