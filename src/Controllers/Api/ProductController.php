<?php

namespace App\Controllers\Api;

use App\Exceptions\ProductValidationException;
use App\Kernel\Controller;
use App\Model\Product;
use App\Requests\ProductRequest;
use App\UseCases\GetProductCategoriesUseCase;
use App\UseCases\GetProductsUseCase;
use App\UseCases\GetProductsWithMediansUseCase;
use App\UseCases\ImportProductUseCase;

class ProductController extends Controller
{
    public function index()
    {
        $request = $this->getRequest();

        $filters = [
            'category'   => $request->input('cat'),
            'search'     => $request->input('q'),
            'min_price'  => $request->input('min'),
            'max_price'  => $request->input('max'),
            'in_stock'   => $request->input('inStock'),
        ];

        $sortParam = $request->input('sort', 'date_desc');
        [$sortBy, $sortDir] = $this->parseSort($sortParam);

        $sort = [
            'field' => $sortBy,
            'direction' => $sortDir,
        ];

        $page    = (int)$request->input('page', 1);
        $perPage = (int)$request->input('perPage', 12);

        $result = GetProductsWithMediansUseCase::execute($filters, $sort, $page, $perPage);

        $this->json($result);
    }

    private function parseSort(string $sortParam): array
    {
        $map = [
            'price'  => 'price',
            'date'   => 'created_at',
            'rating' => 'rating',
        ];

        [$field, $direction] = array_pad(explode('_', $sortParam), 2, 'asc');

        $field = $map[$field] ?? 'created_at';
        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? strtolower($direction) : 'asc';

        return [$field, $direction];
    }

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

        $data = $request->data();
        $file = $data['products'];

        try {
            $result = ImportProductUseCase::execute($file['tmp_name'], $file['type']);

            $this->json($result);
        } catch (ProductValidationException $e) {
            $this->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'errors' => $e->getErrors()
            ]);
        } catch (\Exception $e) {
            $this->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function categories()
    {
        $categories = GetProductCategoriesUseCase::execute();

        $this->json([
            'status' => 'success',
            'categories' => $categories
        ]);
    }
}