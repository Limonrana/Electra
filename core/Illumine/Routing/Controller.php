<?php

namespace Illumine\Routing;

use Illumine\Foundation\Application;

class Controller
{
    /**
     * The application view instance.
     *
     * @var \Illumine\Foundation\Application
     */
    public function view($view, $data = [])
    {
        return Application::$app->router->renderView($view, $data);
    }

}