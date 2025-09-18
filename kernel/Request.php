<?php

namespace App\Kernel;

class Request
{
    public array $get, $post, $queryParams, $files;
    protected array $errors = [];

    public function __construct(
        array $get,
        array $post,
        array $files
    )
    {
        $this->get = $get;
        $this->post = $post;
        $this->files = $files;
        $this->queryParams = $get;
    }

    public static function createFromGlobals()
    {
        return new static($_GET, $_POST, $_FILES);
    }

    public function uri(): string
    {
        return strtok($_SERVER['REQUEST_URI'], '?');
    }

    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function file(string $key): ?array
    {
        return $this->files[$key] ?? null;
    }

    public function input(string $key, $default = null)
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function rules(): array
    {
        return [];
    }

    public function validate(): bool
    {
        $this->errors = [];

        foreach ($this->rules() as $field => $rules) {
            $rules = explode('|', $rules);

            foreach ($rules as $rule) {
                if ($rule === 'required') {
                    $value = $this->input($field);
                    $file = $this->file($field);

                    if (($value === null || $value === '') && !$file) {
                        $this->errors[$field][] = "Поле {$field} обязательно.";
                    }
                }

                if ($rule === 'file') {
                    $file = $this->file($field);

                    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
                        $this->errors[$field][] = "Поле {$field} должно быть файлом.";
                    }
                }
            }
        }

        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}