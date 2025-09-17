<?php

namespace App\Kernel;

class Router
{
    private Request $request;
    private View $view;
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function __construct(
        Request $request,
        View $view
    )
    {
        $this->request = $request;
        $this->initRoutes();
        $this->view = $view;
    }

    public function dispatch(string $uri, string $method)
    {
        $route = $this->findRoute($uri, $method);
        if (!$route) {
            echo json_encode(['error' => 'not found']);
            exit();
        }
        if (is_array($route->getAction())) {
            [$controller, $action] = $route->getAction();

            /** @var Controller $controller */
            $controller = new $controller();

            call_user_func([$controller, 'setRequest'], $this->request);
            call_user_func([$controller, 'setView'], $this->view);

            call_user_func([$controller, $action]);
        } else {
            call_user_func($route->getAction());
        }
    }

    /**
     * @param string $uri
     * @param string $method
     * @return false|Route
     */
    private function findRoute(string $uri, string $method)
    {
        if (!isset($this->routes[$method][$uri])) {
            return false;
        }

        return $this->routes[$method][$uri];
    }

    private function initRoutes(): void
    {
        $routes = $this->getRoutes();

        foreach ($routes as $route) {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }
    }

    private function getRoutes(): array
    {
        return require_once APP_PATH.'/src/routes.php';
    }
}