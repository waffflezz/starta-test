<?php

namespace App\Kernel;

use App\Kernel\Exceptions\ViewNotFoundException;

abstract class Controller {
    private Request $request;
    private View $view;

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request): void
    {
        $this->request = $request;
    }

    /**
     * @throws ViewNotFoundException
     */
    public function render(string $view): void
    {
        $this->view->page($view);
    }

    /**
     * @param mixed $view
     */
    public function setView($view): void
    {
        $this->view = $view;
    }
}