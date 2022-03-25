<?php

namespace Illumine\Routing;

use Illumine\Foundation\Application;
use Illumine\Http\Request;
use Illumine\Http\Response;
use Illumine\View\View;

class Router
{
    /**
     * The route collection instance.
     *
     * @var array \Illumine\Routing\Router
     */
    protected $routes = [];


    /**
     * All of the verbs supported by the router.
     *
     * @var string[]
     */
    public static $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];

    /**
     * The request instance.
     *
     * @return Request
     */
    public Request $request;

    /**
     * The response instance.
     *
     * @var \Illumine\Http\Response
     */
    public Response $response;

    /**
     * Create a new Router instance.
     *
     * @param array $routes
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Register a new GET route with the router.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return \Illumine\Routing\Router
     */
    public function get($uri, $action = null)
    {
        $this->addRoute('GET', $uri, $action);
    }

    /**
     * Register a new POST route with the router.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return \Illumine\Routing\Router
     */
    public function post($uri, $action = null)
    {
        $this->addRoute('POST', $uri, $action);
    }

    /**
     * Register a new PUT route with the router.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return \Illumine\Routing\Router
     */
    public function put($uri, $action = null)
    {
        $this->addRoute('PUT', $uri, $action);
    }

    /**
     * Register a new PATCH route with the router.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return \Illumine\Routing\Router
     */
    public function patch($uri, $action = null)
    {
        $this->addRoute('PATCH', $uri, $action);
    }

    /**
     * Register a new DELETE route with the router.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return \Illumine\Routing\Router
     */
    public function delete($uri, $action = null)
    {
        $this->addRoute('DELETE', $uri, $action);
    }

    /**
     * Register a new OPTIONS route with the router.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return \Illumine\Routing\Router
     */
    public function options($uri, $action = null)
    {
        $this->addRoute('OPTIONS', $uri, $action);
    }

    /**
     * Register a new route responding to all verbs.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return \Illumine\Routing\Router
     */
    public function any($uri, $action = null)
    {
        $this->addRoute('ANY', $uri, $action);
    }

    /**
     * Register a new Fallback route with the router.
     *
     * @param  array|string|callable|null  $action
     * @return \Illumine\Routing\Router
     */
    public function fallback($action)
    {
        //
    }

    /**
     * Register a new route with the given verbs.
     *
     * @param  array|string  $methods
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return \Illumine\Routing\Router
     */
    public function match($methods, $uri, $action = null)
    {
        //
    }

    /**
     * Register a new route with the router.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return \Illumine\Routing\Router
     */
    public function addRoute($method, $uri, $action = null)
    {
        $this->routes[$method][$uri] = $action;
    }

    /**
     * Get the route collection instance.
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Get the route collection instance.
     *
     * @return array
     */
    public function getRoute($method, $uri)
    {
        return $this->routes[$method][$uri];
    }

    /**
     * Get the route collection instance.
     *
     * @return array
     */
    public function getRouteByName($name)
    {
        return $this->routes[$name];
    }

    /**
     * Get the route collection instance.
     *
     * @return array
     */
    public function getRouteByAction($action)
    {
        foreach ($this->routes as $method => $routes) {
            foreach ($routes as $uri => $route) {
                if ($route == $action) {
                    return [$method, $uri];
                }
            }
        }
    }

    /**
     * Get the route collection instance.
     *
     * @return array
     */
    public function getRouteByController($controller)
    {
        foreach ($this->routes as $method => $routes) {
            foreach ($routes as $uri => $route) {
                if (is_array($route) && $route['controller'] == $controller) {
                    return [$method, $uri];
                }
            }
        }
    }

    /**
     * Dispatch the route.
     *
     * @return mixed
     */
    public function dispatch()
    {
        $method = $this->request->getMethod();
        $path = $this->request->getPath();

       return $this->dispatchRoute($method, $path);
    }


    /**
     * Dispatch the route.
     *
     * @return mixed
     */
    public function dispatchRoute($method, $uri)
    {
        $callback = $this->routes[$method][$uri] ?? false;

        if (!$callback) {
            $this->response->setStatusCode(404);
            if (!file_exists(Application::$BASE_PATH. '/resources/views/errors/404.electra.php')) {
                return $this->renderContent("OOPS! Route is not defined.");
            }
            return $this->renderView('errors/404');
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
        }

        return call_user_func($callback, $this->request, $this->response);
    }

    /**
     * CallAction the controller.
     *
     * @return Void
     */
    public function callAction($controller, $method)
    {
        $controller = new $controller;

        $controller->$method();
    }


    /**
     * Render the view.
     *
     * @return
     */
    public function renderView($view, array $data = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->viewContent($view, $data);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Render Content the view.
     *
     * @return
     */
    public function renderContent($view)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $view, $layoutContent);
    }

    public function layoutContent()
    {
        ob_start();
        include_once Application::$BASE_PATH."/resources/views/layout/layout.electra.php";
        return ob_get_clean();
    }

    public function viewContent($view, $data)
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$BASE_PATH."/resources/views/$view.electra.php";
        return ob_get_clean();
    }
}