<?php

namespace App\Kernel;


class App {
    private Router $router;
    private Request $request;

    public function __construct() {
        $this->request = Request::createFromGlobals();
        $this->router = new Router($this->request, new View());
    }

    public function run(): void {
        $this->router->dispatch($this->request->uri(), $this->request->method(), '/products');
    }
}