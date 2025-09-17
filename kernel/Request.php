<?php

namespace App\Kernel;

class Request
{
    public array $get, $post, $queryParams;

    public function __construct(
        array $get,
        array $post
    )
    {
        $this->get = $get;
        $this->post = $post;
        $this->queryParams = $get;
    }

    public static function createFromGlobals()
    {
        return new static($_GET, $_POST);
    }

    public function uri(): string
    {
        return strtok($_SERVER['REQUEST_URI'], '?');
    }

    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function input(string $key, $default = null)
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }
}