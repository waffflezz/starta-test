<?php

namespace App\Kernel;

class Route
{
    /** @var string */
    private $uri;
    /** @var string */
    private $method;
    private $action;
    public function __construct(
        string $uri,
        string $method,
               $action
    )
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->action = $action;
    }

    public static function get(string $uri, $action)
    {
        return new static($uri, 'GET', $action);
    }

    public static function post(string $uri, $action)
    {
        return new static($uri, 'POST', $action);
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getAction(): callable|array
    {
        return $this->action;
    }
}