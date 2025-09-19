<?php

namespace App\Exceptions;


class ProductValidationException extends \Exception
{
    protected array $errors;

    public function __construct(array $errors, string $message = "Ошибка валидации продуктов", int $code = 422)
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}