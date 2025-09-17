<?php

namespace App\Kernel;

use App\Kernel\Exceptions\ViewNotFoundException;

class View
{
    /**
     * @throws ViewNotFoundException
     */
    public function page(string $name): void
    {
        $viewPath = APP_PATH . "/src/Views/Pages/$name.php";

        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException("View $name not found");
        }

        extract([
            'view' => $this,
        ]);

        include_once $viewPath;
    }

    public function component(string $name): void
    {
        $componentPath = APP_PATH . "/src/Views/Components/$name.php";

        if (!file_exists($componentPath)) {
            echo "Component $name not found";
            return;
        }

        include_once $componentPath;
    }
}